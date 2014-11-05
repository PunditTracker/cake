<?php
/**
 * File used as Users Controller
 *
 * This controller is mainly for Users.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */
App::import('Vendor', 'mailchimp/MCAPI');
/**
 * Users controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class UsersController extends AppController {


  /**
   * array to hold component.
   *
   * @return void
   */
  public $components = array('RequestHandler');


  /**
   * array to hold helper.
   *
   * @return void
   */
  public $helpers = array('Js');


  /**
   * different models used
   *
   * @array contains models
   */
  public $uses = array('User', 'Call', 'Vote', 'CallDummy', 'Aro', 'Pundit', 'Outcome');


  /**
   * method call before any action.
   *
   * return void
   */
  public function beforeFilter() {
    parent::beforeFilter();
     //$this->Auth->allow('admin_migrate_db');
  }//end beforeFilter()


  /**
   * login method
   *
   * @return void
   */
  function login($fbFlag = null) {

    $response = array();
    if ($this->Auth->loggedIn()) {
      $this->redirect('/');
    }
    if (!$this->isMobile) {
      $this->layout = false;
    }

    if (!$this->request->is('post')) {
      Configure::load('facebook');
      $this->Auth->authenticate = array('Facebook');
    }
    if ($this->request->is('post')) {

      if(empty($this->request->data['User']['email'])) {
        $response['email'] = "Please enter email";
      }
      if (empty($this->request->data['User']['password'])) {
        $response['password'] = "Please enter password";
      }

      if (!empty($this->request->data['User']['email']) && !empty($this->request->data['User']['password'])) {
        if ($this->Auth->login()) {
          // If remember me is checked
          if (!empty($this->request->data['User']['remember_me'])) {
            $this->__setRememberMe();
          }
          $groupInfo = $this->getParentGroup((int)$this->Auth->user('id'));
          if (!empty($groupInfo['parent_group'])) {
            $this->Session->write('Auth.User.userGroup', $groupInfo['parent_group']);
          }

          $response['success'] = "true";
          $response['redirect'] = Router::url($this->Auth->redirect(), true);

        } else {
          $response['authFail'] = __("Your username or password was incorrect.");

        }
      }

      return $this->sendJson($response, true);
      exit;

    } else if ('fb' == $fbFlag && $this->Auth->login()) {
      // Checks for facebook permissions, registers user if not registered.
      $this->_checkBeforeRegistration();

      // Updates username probably half the time user logs in
      $this->User->updateUsername($this->Auth->user());
      // If referer was error page then redirect to home page
      $redirectUrl = $this->Auth->redirect();
      if ($redirectUrl == '/users/home') {
          $redirectUrl = '/';
      }
      // Read the entire user info from db and write it in session
      $userInfo = $this->User->find('first', array(
        'contain' => false,
        'conditions' => array('User.id' => $this->Auth->user('id')),
      ));
      $this->Session->write('Auth.User', $userInfo['User']);
      $groupInfo = $this->getParentGroup((int)$this->Auth->user('id'));
      if (!empty($groupInfo['parent_group'])) {
        $this->Session->write('Auth.User.userGroup', $groupInfo['parent_group']);
      }

      $this->redirect($redirectUrl);
    }
  }//end login()


  /**
   * Method to set the remember me cookie
   *
   * @return void
   */
  private function __setRememberMe() {

     if (!isset($this->Cookie)) {
      $this->Cookie = $this->Components->load('Cookie');
    }


    $rememberMeData = array(
      'email' => $this->request->data['User']['email'],
      'password' => $this->request->data['User']['password'],
    );

    setcookie('pt_remember_me', base64_encode(serialize($rememberMeData)), strtotime('+2 weeks'), '/');
  }//end __setRememberMe()


  /**
   * logout method
   *
   * @return void
   */
  function logout() {

    setcookie('pt_remember_me', null, strtotime('-1 day'), '/');
    $this->Session->destroy();
    $this->Session->setFlash(__('Successfully logged out of the system.'), 'Flash/success', array('class' => 'hide'));
    $this->redirect($this->Auth->logout());
  }//end logout()


  /**
   * sign up method
   *
   * @return void
   */
  public function signup() {
    $this->request->data['User']['group_id'] = Configure::read('general_user_group_id');

    $response['success'] = 'false';
    if ($this->request->is('post')) {
      if ($this->User->save($this->request->data)) {
        if ($this->Auth->login()) {
          $groupInfo = $this->getParentGroup((int)$this->Auth->user('id'));
          if (!empty($groupInfo['parent_group'])) {
            $this->Session->write('Auth.User.userGroup', $groupInfo['parent_group']);
          }
          $response['success'] = 'true';

          $this->__mailchimp_subscription($this->request->data['User']);
        }
      } else {
        $response['failure'] = $this->User->validationErrors;
      }
    }
    if (!$this->isMobile || $this->request->isAjax()) {
      $this->layout = false;
    }
    if ($this->request->isAjax()) {
      return $this->sendJson($response, true);
    }
  }//end signup()


  /**
   * home page
   *
   * @return void
   */
  public function home() {

    $option = array(
      'conditions' => array(
        'Call.featured' => 1,
        'Call.approved' => 1,
      ),
      'contain' => array(
        'User',
        'Category',
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          )
        )
      ),
      'order' => array(
        'Call.outcome_id ASC',
        'Call.vote_end_date DESC'
      ),
    );
    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey'  => 'user_id',
            'type'        => 'inner',
          ),
        ),
      ), false
    );
    $calls = $this->Call->find('all', $option);

    $topPundit = $this->Call->Category->getTopPundit(null, 3);

    $topUser = $this->Vote->getTopUser();
    $this->set(compact('calls', 'topPundit', 'topUser'));
    $this->set('title_for_layout', __('PunditTracker | Bringing Accountability to the Prediction Industry'));

  }//end home()


  /**
   * user profile page
   *
   * @param string $slug slug
   *
   * @return void
   */
  public function profile($slug = null, $predictionSlug = null) {

    // If slug is empty and a user is currently logged in, then redirect to his own profile with his slug
    if (empty($slug) && $this->Auth->user('id')) {
      $redirect = array(
        'action' => 'profile',
        $this->Auth->user('slug'),
      );
      $this->redirect($redirect);
    }

    $response = $this->User->__checkValidSlug($slug, $predictionSlug);
    if ($response['success']) {
      $userId = !empty($response['User']['id']) ? $response['User']['id'] : $this->Auth->user('id');
      if ($response['prediction']) {
       // debug($response['data']);
       // debug($response);
        $this->set(compact('response', 'slug', 'predictionSlug'));
      } else {
        $admin = false;
        if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
          $admin = true;
        }
        if (false == $this->User->validUser($userId, Configure::read('general_user_group_id'), $admin)) {
          $this->redirect(array('controller' => 'users', 'action' => 'home'));
        }
        if (!empty($this->params->params['named']['archive'])) {
          $this->setAction('live_archive_call', $userId);
        } else {
          $this->setAction('live_archive_call', $userId);
        }
      }

    } else {
      return $this->redirect($response['location'], 301);
    }

  }//end profile()

  /**
   * user profile all calls with pagination page
   *
   * @param string $slug slug
   *
   * @return void
   */
  public function profile_calls($slug = null, $predictionSlug = null) {

    $response = $this->User->__checkValidSlug($slug, $predictionSlug);
    if ($response['success']) {
      $userId = !empty($response['User']['id']) ? $response['User']['id'] : $this->Auth->user('id');
      if ($response['prediction']) {
       // debug($response['data']);
       // debug($response);
        $this->set(compact('response', 'slug', 'predictionSlug'));
      } else {
        $admin = false;
        if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
          $admin = true;
        }
        if (false == $this->User->validUser($userId, Configure::read('general_user_group_id'), $admin)) {
          $this->redirect(array('controller' => 'users', 'action' => 'home'));
        }
        if (!empty($this->params->params['named']['archive'])) {
          $this->setAction('archive_call', $userId);
        } else {
          $this->setAction('live_call', $userId);
        }
      }

    } else {
      return $this->redirect($response['location'], 301);
    }

  }//end profile()

  /**
   * Method is used to view pundit live call
   *
   * @param string $userId user id
   *
   * @return void
   */
  public function live_call($userId = null)
  {
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $userId = !empty($userId) ? $userId : $this->Auth->user('id');
    $selectedTab = 'liveCalls';
    $option  = array(
      'conditions' => array(
        'User.id' => $userId,
      ),
      'contain' => false
    );
    $currentUserData = $this->User->find('first', $option);
    $currentUserData['tracked'] = $this->Vote->field('min(created)', array('user_id' => $userId));
    $this->paginate = array(
      'conditions' => array(
        'OR' => array(
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
        'Call.approved' => 1,
      ),
      'joins' => array(
        array(
          'table' => 'votes',
            'alias' => 'Vote',
            'type' => 'INNER',
            'conditions' => array(
              'Call.id = Vote.call_id',
              'Vote.user_id' => $userId,
            )
        )
      ),
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'user_id' => $userId,
          )
        ),
        'Category',
        'User'
      ),
      'limit' => 20
    );
    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey'  => 'user_id',
            'type'        => 'inner',
          ),
        ),
      ), false
    );

    $canonicalUrl = array(
      'action' => 'profile',
      $currentUserData['User']['slug'],
    );
      $earned = $this->User->Vote->find('all',
                                        array(
                                          'fields' =>
                                          array(
                                            '(User.score - 1) * ( User.calls_graded ) as earned'
                                          ),
                                          'conditions' =>
                                          array(
                                            'Vote.user_id' => $userId
                                          ),
                                        )
                                      );
    $this->set(compact('earned'));
    $this->set("title_for_layout", "{$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}'s Predictions &amp; Picks");
    $this->set('metaDescription', "See how {$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}’s predictions have done. Can you do better? ");
    $this->set('userProfileData', $this->paginate('Call'));
    $this->set('ranking', $this->User->Vote->userRanking($userId));
    $this->set(compact('currentUserData', 'selectedTab', 'userId', 'canonicalUrl'));
    $this->set('outcomes', $this->Outcome->find('list', array('fields' => array('id', 'title'))));



  }//end live_call()


  /**
   * Method is used to view pundit live call
   *
   * @param string $userId user id
   *
   * @return void
   */
  public function archive_call($userId = null)
  {
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $userId = !empty($userId) ? $userId : $this->Auth->user('id');
    $selectedTab = 'archiveCalls';
    $option  = array(
      'conditions' => array(
        'User.id' => $userId,
      ),
      'contain' => false
    );
    $currentUserData = $this->User->find('first', $option);

    $this->paginate = array(
      'conditions' => array(
        'outcome_id NOT' => null,
        'CallDummy.approved' => 1,
      ),
      'joins' => array(
        array(
          'table' => 'votes',
            'alias' => 'Vote',
            'type' => 'INNER',
            'conditions' => array(
              'CallDummy.id = Vote.call_id',
              'Vote.user_id' => $userId,
            )
          )
      ),
      'contain' => array(
      'Vote' => array(
        'conditions' => array(
        'user_id' => $userId,
        )
      ),
      'Category',
      'User',
      'Outcome'
      ),
      'limit' => 20
    );
    $this->CallDummy->bindModel(
        array(
          'belongsTo' => array(
            'User' => array(
              'foreignKey'  => 'user_id',
              'type'        => 'inner',
            ),
          ),
        ), false
    );

    $canonicalUrl = array(
      'action' => 'profile',
      $currentUserData['User']['slug'],
      //'archive' => true,
    );
      $earned = $this->User->Vote->find('all',
                                        array(
                                          'fields' =>
                                          array(
                                            '(User.score -1) * ( User.calls_graded ) as earned'
                                          ),
                                          'conditions' =>
                                          array(
                                            'Vote.user_id' => $userId
                                          ),
                                        )
                                      );
    $this->set(compact('earned'));
    $this->set("title_for_layout", "{$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}'s Predictions &amp; Picks");
    $this->set('metaDescription', "See how {$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}’s predictions have done. Can you do better? ");
    $this->set('userProfileArchiveData', $this->paginate('CallDummy'));
    $this->set(compact('currentUserData', 'selectedTab', 'userId', 'canonicalUrl'));
    $this->set('ranking', $this->User->Vote->userRanking($userId));
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set('outcomes', $outcomes);
  }//end archive_call()

  /**
   * Method is used to view pundit live and archive call without pagination
   *
   * @param string $userId user id
   *
   * @return void
   */
  public function live_archive_call($userId = null)
  {
    if(isset($this->params['named']['sort'])) {
      $controller = $this->params['controller'];
      $parameter  = $this->params['pass'][0];
      $this->redirect(array(
        'controller' => $controller,
        'action' => 'profile', $parameter,
        ),
      301
      );
    }
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $userId = !empty($userId) ? $userId : $this->Auth->user('id');
    $selectedTab = 'liveCalls';
    $option  = array(
      'conditions' => array(
        'User.id' => $userId,
      ),
      'contain' => false
    );
    $currentUserData = $this->User->find('first', $option);
    $currentUserData['tracked'] = $this->Vote->field('min(created)', array('user_id' => $userId));
    $this->paginate = array(
      'order' =>
       array('Call.created' => 'desc'),
      'conditions' => array(
        'OR' => array(
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
        'Call.approved' => 1,
      ),
      'joins' => array(
        array(
          'table' => 'votes',
            'alias' => 'Vote',
            'type' => 'INNER',
            'conditions' => array(
              'Call.id = Vote.call_id',
              'Vote.user_id' => $userId,
            )
        )
      ),
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'user_id' => $userId,
          )
        ),
        'Category',
        'User'
      ),
      'limit' => 10
    );

    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey'  => 'user_id',
            'type'        => 'inner',
          ),
        ),
      ), false
    );

    $canonicalUrl = array(
      'action' => 'profile',
      $currentUserData['User']['slug'],
    );

    $this->set("title_for_layout", "{$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}'s Predictions &amp; Picks");
    $this->set('metaDescription', "See how {$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}’s predictions have done. Can you do better? ");
    $this->set('userProfileData', $this->paginate('Call'));
    $this->set('ranking', $this->User->Vote->userRanking($userId));
    $this->set(compact('currentUserData', 'selectedTab', 'userId'/* 'canonicalUrl'*/));
    $this->set('outcomes', $this->Outcome->find('list', array('fields' => array('id', 'title'))));
    $earned = $this->User->Vote->find('all',
                                        array(
                                          'fields' =>
                                          array(
                                            '(User.score -1) * ( User.calls_graded ) as earned'
                                          ),
                                          'conditions' =>
                                          array(
                                            'Vote.user_id' => $userId
                                          ),
                                        )
                                      );
    $this->set(compact('earned'));
    $userId = !empty($userId) ? $userId : $this->Auth->user('id');
    $selectedTab = 'archiveCalls';
    $option  = array(
      'conditions' => array(
        'User.id' => $userId,
      ),
      'contain' => false
    );
    $currentUserData = $this->User->find('first', $option);

    $this->paginate = array(
      'order' =>
       array('CallDummy.created' => 'desc'),
      'conditions' => array(
        'outcome_id NOT' => null,
        'CallDummy.approved' => 1,
      ),
      'joins' => array(
        array(
          'table' => 'votes',
            'alias' => 'Vote',
            'type' => 'INNER',
            'conditions' => array(
              'CallDummy.id = Vote.call_id',
              'Vote.user_id' => $userId,
            )
          )
      ),
      'contain' => array(
      'Vote' => array(
        'conditions' => array(
        'user_id' => $userId,
        )
      ),
      'Category',
      'User',
      'Outcome'
      ),
      'limit' => 10
    );
    $this->CallDummy->bindModel(
        array(
          'belongsTo' => array(
            'User' => array(
              'foreignKey'  => 'user_id',
              'type'        => 'inner',
            ),
          ),
        ), false
    );

    $canonicalUrl = array(
      'action' => 'profile',
      $currentUserData['User']['slug'],
      'archive' => true,
    );

    $this->set("title_for_layout", "{$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}'s Predictions &amp; Picks");
    $this->set('metaDescription', "See how {$currentUserData['User']['first_name']} {$currentUserData['User']['last_name']}’s predictions have done. Can you do better? ");
    $this->set('userProfileArchiveData', $this->paginate('CallDummy'));
    $this->set(compact('currentUserData', 'selectedTab', 'userId' /* 'canonicalUrl'*/));
    $this->set('ranking', $this->User->Vote->userRanking($userId));
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set('outcomes', $outcomes);
    $this->set('live_archive_call','live_archive_call');

  }//end live_archive_call()

  /**
   * Method is used to review admin dashboard
   *
   * @return void
   */
  public function admin_index()
  {
    $this->User->bindModel(
      array(
        'hasOne' => array(
          'Aro' => array(
            'foreignKey' => 'foreign_key',
            'type' => 'inner',
            'conditions' => array(
             'Aro.parent_id' => Configure::read('general_user_group_id')
            ),
          ),
        ),
      ), false
    );
    $option = array(
      'fields' => array(
        'User.*',
        '(SELECT COUNT(Vote.id) FROM votes Vote WHERE User.id = Vote.user_id) as vote_count',
        //'(SELECT COUNT(Vote.id) FROM votes Vote WHERE User.id = Vote.user_id AND Vote.is_calculated = 1) as votes_graded',
      ),
    );

    if (!empty($this->request->params['named']['sort']) && (in_array($this->request->params['named']['sort'], array('vote_count', 'votes_graded')))) {
      $direction = (!empty($this->request->params['named']['direction']) ? $this->request->params['named']['direction'] : 'DESC');
      $option['order'] = $this->request->params['named']['sort'] . ' ' . $direction;
      $tmpSort = $this->request->params['named']['sort'];
      unset($this->request->params['named']['sort']);
    }

    $this->paginate = $option;
    $this->User->contain('Aro');
    $this->set('allUserData', $this->paginate('User'));
    if (!empty($tmpSort)) {
      $this->request->params['named']['sort'] = $tmpSort;
    }
  }//end admin_index()


  /**
   * delete method
   *
   * @param integer $id user id
   *
   * @return void
   */
  public function admin_delete($id = null) {
    if (!$this->request->is('ajax')) {
      throw new MethodNotAllowedException();
    }
    $this->User->id = $id;
    $response['success']   = false;
    $response['message']   = 'User not deleted';
    if ($this->request->is('ajax')) {
      if ($this->User->delete($id)) {
        $response['success']   = true;
        $response['message']   = 'User deleted Successfully';
      }
    }
    return $this->sendJson($response);
  }//end admin_delete()


  /**
   * method used to edit user
   *
   * @param string $id user id
   *
   * @return void
   */
  public function admin_edit($id = null)
  {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid User'));
    }
    $className = 'hide';
    $linkClassName = '';
    if ($this->request->is('post') || $this->request->is('put')) {
      if (4 == $this->request->data['User']['filename']['error']) {
        unset($this->request->data['User']['filename']);
      }
      if ($this->User->save($this->request->data)) {
        $this->setFlash(__('The user information has been updated.'));
        if ($this->isMobile) {
          $this->redirect(array('controller' => 'users', 'action' => 'profile', 'admin' => false, $id));
        }
        $this->render('/Elements/iframeclose');
      } else {
        //$this->setFlash(__('The user could not updated. Please, try again.'), 'error');
      }
      if (isset($this->User->validationErrors['filename'])) {
        $className = 'show';
        $linkClassName = 'hide';
      }
      $this->set('className', $className);
      $this->set('linkClassName', $linkClassName);
      $this->request->data['User']['avatar'] = $this->User->field(
        'User.avatar',
        array(
          'User.id' => $this->User->id
        )
      );
    } else {
      $this->User->contain();
      $this->set('className', $className);
      $this->set('linkClassName', $linkClassName);
      $this->request->data = $this->User->read(null, $id);
    }
  }//end admin_edit()


  /**
   * method used to edit user
   *
   * @param integer $id user id
   *
   * @return void
   */
  public function admin_user_view($id = null)
  {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid User'));
    }
    $this->User->contain();
    $this->request->data = $this->User->read(null, $id);
  }//end admin_edit()


  /**
   * This action is used to check if user has permitted application to access his facebook data.
   *
   * @return boolean
   */
  function __checkPermitted()
  {
    // Read configured facebook permissions.
    $permsissionsNeeded = Configure::read('fbPermissionsArray');

    // Get user's permissions from Facebook.
    $facebook = getFbInstance();
    try {
      $permissionsList = $facebook->api(
        '/me/permissions',
        'GET',
        array('access_token' => $this->Session->read('Auth.User.access_token'))
      );
    } catch(FacebookApiException $e) {
      $result = $e->getResult();
      CakeLog::write('info', "Facebook Api Error : {$result['error']['message']}");
      return false;
    }

    // Checks if application have access to required user permissions.
    foreach ($permsissionsNeeded as $perm) {
      if (!isset($permissionsList['data'][0][$perm]) || $permissionsList['data'][0][$perm] != 1 ) {
        return false;
      }
    }
    return true;
  }//end __checkPermitted()


  /**
   * This action method is used to log user in.
   *
   * @return void
   */
  private function _checkBeforeRegistration()
  {
    // Checks the user permissions, if do not have valid permissions, deletes auth data.
    if ( ! $this->__checkPermitted()) {
      //$this->__getPermissions();
      // logs out and delete temporary auth and facebook data
      $url = $this->Auth->logout();
      $this->Session->destroy();

      $this->redirect(array('controller' => 'users', 'action' => 'permission'));
    }

    // Registers user if not already registered.
    if ( ! $this->__checkRegistered()) {
      $this->__doRegister();
    }
  }//end _checkBeforeRegistration()


  /**
   * Action method used to check wheter user is registered.
   *
   * @return boolean
   */
  function __checkRegistered()
  {
    $user = $this->Auth->user();

    // Get saved user id of facebook user.
    $dbUserId = $this->User->field('User.id', array('fb_id' => $user['fb_id']));

    // If user exists in databse, sets user's id and returns true.
    if ($dbUserId) {
      $this->Session->write('Auth.User.id', $dbUserId);
      return true;
    } else {
      return false;
    }
  }//end __checkRegistered()


  /**
   * Action method used to register the user.
   *
   * @return boolean
   */
  function __doRegister()
  {
    // Save user.
    $data = $this->Auth->user();
    if ($this->User->save($data)) {
      $this->__mailchimp_subscription($data);
      $userId = $this->User->id;
      $parentGroupId = Configure::read('general_user_group_id');
      $this->Session->write('Auth.User.id', $userId);
      $this->User->setUserGroup($userId, $parentGroupId);

      return true;
    } else {
      // If user was not saved, writes log and returns false.
      CakeLog::write('info', "Could not register user : ".print_r($this->User->validationErrors, true));
      return false;
    }
  }//end __doRegister()


  /**
   * method used to edit profile info
   *
   * @return void
   */
  public function edit_info()
  {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    $this->User->id = $this->Auth->user('id');
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid User'));
    }
    $className = 'hide';
    $linkClassName = '';
    if ($this->request->is('post') || $this->request->is('put')) {
      if (4 == $this->request->data['User']['filename']['error']) {
        unset($this->request->data['User']['filename']);
      }
      if ($this->User->save($this->request->data)) {
        $this->setFlash(__('The user information has been updated.'));
        if ($this->isMobile) {
          $this->redirect(
            array(
              'controller' => 'users',
              'action'     => 'profile',
            )
          );
        } else {
          $this->render('/Elements/User/edit_info');
        }
        //$this->render('/Elements/iframeclose');
      } else {
        //$this->setFlash(__('The user could not updated. Please, try again.'), 'error');
      }
      if (isset($this->User->validationErrors['filename'])) {
        $className = 'show';
        $linkClassName = 'hide';
      }
      $this->set('className', $className);
      $this->set('linkClassName', $linkClassName);
      $this->request->data['User']['avatar'] = $this->User->field(
        'User.avatar',
        array(
          'User.id' => $this->User->id
        )
      );
    } else {
      $this->User->contain();
      $this->set('className', $className);
      $this->set('linkClassName', $linkClassName);
      $this->request->data = $this->User->read(null);
    }
  }//end edit_info()


  /**
   * method used to change password
   *
   * @return void
   */
  public function reset_password()
  {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    $this->User->id = $this->Auth->user('id');
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid User'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {

      // Unset password and confirm password if blank.
      if (empty($this->request->data['User']['password'])
      && empty($this->request->data['User']['password2'])) {
        unset($this->request->data['User']['password']);
        unset($this->request->data['User']['password2']);
      }
      if ($this->User->save($this->request->data)) {
        $this->setFlash(__('Password updated.'));
        if ($this->isMobile) {
          $this->redirect(array('action' => 'profile'));
        } else {
          $this->render('/Elements/iframeclose');
        }
      } else {
        //$this->setFlash(__('Password could not updated. Please, try again.'), 'error');
      }
    }
  }//end reset_password()


  /**
   * method used for forgot password
   *
   * @return void
   */
  public function forgot_password()
  {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    if ($this->request->is('post') || $this->request->is('put')) {

      $email = $this->request->data['User']['email'];
      unset($this->User->validate['email']['unique']);
      $userId = $this->User->field(
        'id',
        array(
          'email' => $email
        )
      );
      $this->User->id = $userId;
      //check whether user exist or not
      if (!$userId) {
        $this->Session->setFlash(__('Email does not exist.'), 'Flash/error');
      } else {
        //generate a new code which is to be send as email
        $data['User']['reset_password_code'] = md5(uniqid(time()));
        $data['User']['reset_password_date'] = date('Y-m-d H:i:s');
        $data['User']['email'] = $email;
        //saving data
        if ($this->User->save($data)) {
          if($this->__sendResetPasswordEmail($email, $data['User']['reset_password_code'])) {
            if ($this->isMobile) {
              $this->Session->setFlash(__('Password reset link has been sent to your e-mail. Please click the link to complete the reset process.'));
              $this->redirect('/');
            } else {
              $this->Session->setFlash(__('Password reset link has been sent to your e-mail. Please click the link to complete the reset process.'), 'Flash/success');
              $this->render('/Elements/User/iframeclose');
            }
          } else {
            $this->Session->setFlash(__('Failed to send reset password e-mail.'), 'Flash/error');
          }
        } else {
          $this->Session->setFlash(__('Please enter a valid email'), 'Flash/error');
        }
      }
    }

  }//end forgot_password()


  /**
   * This method is used to send reset password email to user
   * email contains a reset password link,
   * on clicking this link user can change their password
   *
   * @param string $email
   * @param string $activationCode
   * @return boolean
   */
  function __sendResetPasswordEmail($email, $activationCode)
  {
    //set sctivation url
    $activationLink = Router::url(
      array(
        'controller' => 'users',
        'action' => 'reset_new',
        $activationCode
      ),
      true
    );
    //set options for sending email
    $options = array(
      'to'          => $email,
      'from'        => Configure::read('email_from'),
      'subject'     => Configure::read('forgot_password_email_subject'),
      'template'    => 'forgot_password',
      'emailFormat' => 'both',
      'viewVars'    => array('activationLink' => $activationLink),
    );
    //call function to send email
    return $this->_sendEmail($options);
  }//end __sendResetPasswordEmail()


  /**
   * This method is used to change user's password
   *
   * @param String $code generated code
   *
   * @return void
   */
  public function reset_new($code = null)
  {
    $this->autorender = false;
    if (!empty($code)) {
      $options = array(
        'contain'    => false,
        'conditions' => array(
          'User.reset_password_code'    => $code
        ),
        'fields'     => array(
          'User.id',
          'User.reset_password_date',
          'User.email'
        ),
      );
      // Find the user with passed reset code
      $userInfo = $this->User->find('first', $options);
      if (!$userInfo) {
        $this->setFlash(__('Invalid activation code.'), 'error');
      } else if (count($userInfo > 0)) {
        $alphNums     = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $tempPassword = substr(str_shuffle($alphNums),0,6);
        $this->User->id = $userInfo['User']['id'];
        $data['User']['password'] = $tempPassword;
        $email = $userInfo['User']['email'];
        if($this->__sendTemporaryPasswordEmail($email, $tempPassword)) {
          $this->User->save($data);
          $this->setFlash(__('Temporary password sent to your email. Please login using this and then reset your password using profile manager.'));
          $this->redirect(array('controller' => 'users', 'action' => 'home'));
        } else {
          $this->setFlash(__('Failed to send temporary password. Please try again.'), 'error');
        }
      } /*else {
        $this->setFlash(__('Invalid activation code.'), 'error');
      }*/
    } else {
      $this->setFlash(__('Invalid activation code.'), 'error');
    }
  }//end reset_new()


  /**
   * This method is used to send reset password email to user
   * email contains a reset password link,
   * on clicking this link user can change their password
   *
   * @param string $email
   * @param string $tempPassword
   * @return boolean
   */
  function __sendTemporaryPasswordEmail($email, $tempPassword)
  {
    //set options for sending email
    $options = array(
      'to'          => $email,
      'from'        => Configure::read('email_from'),
      'subject'     => Configure::read('temporary_password_email_subject'),
      'template'    => 'temporary_password',
      'emailFormat' => 'both',
      'viewVars'    => array('tempPassword' => $tempPassword),
    );
    //call function to send email
    return $this->_sendEmail($options);
  }//end __sendTemporaryPasswordEmail()


  /**
   * Method to create slug
   *
   * @return void
   */
  function admin_slug() {
    $this->layout = false;
    $this->autoRender = false;
    $users = $this->User->find('all', array('fields' => array('id', 'first_name', 'last_name')));
    foreach ($users as $user) {
      $this->User->id = $user['User']['id'];
      $this->User->save($user);
    }
    print("DONE");

  }//end admin_slug


  /**
   * Method to create slug
   *
   * @return void
   */
  function user_info($userId = null) {

    $userId = !empty($userId) ? $userId : $this->Auth->user('id');
    $userInfo = $this->User->find('first', array('conditions' => array('User.id' => $userId)));
    $userInfo['tracked'] = $this->Vote->field('min(created)', array('user_id' => $userId));
    $this->set(compact('userInfo'));
    $this->set('ranking', $this->User->Vote->userRanking($userId));
    $this->render('/Elements/User/user_profile_info');
  }//end user_info()


  /**
   * Method is used to update user score
   *
   * @return void
   */
  function admin_score_update() {
    set_time_limit(60);
    $this->layout = false;
    $this->autoRender = false;
    $options = array(
      'conditions' => array('outcome_id >' => '0'),
      'contain'    => false
    );
    $archiveCalls = $this->Call->find('all', $options);
    foreach ($archiveCalls as $archiveCall) {
      $this->Vote->updateVotedUserScore($archiveCall['Call'], $archiveCall['Call']['id']);
    }

    print("<strong>All Users score has been updated");

  }//end admin_score_update()


  /**
   * This method is used to subscribe user for mailchimp
   *
   * @return boolean
   */
  function __mailchimp_subscription($data = array()) {
    $api = new MCAPI(Configure::read('MCAPI_KEY'));
    $mergeVars = array(
      'FNAME' => $data['first_name'],
      'LNAME' => $data['last_name'],
    );
    $retval = $api->listSubscribe(Configure::read('MCAPI_LISTID'), $data['email'], $mergeVars);

    return true;
  }//end __mailchimp_subscription()


  /**
   * Function to update user scores.
   *
   * @return void
   */
  public function update_user_scores() {
    echo "Update user score started. <br />";
    $users = $this->User->find('list');
    foreach ($users as $userId) {
      // Call to the function to update user scores.
      $this->Vote->refreshUserScore($userId);

      echo "Score updated for user id = $userId <br />";
    }
    echo "Update user score completed.";
    exit;
  }//end update_user_scores()

    /**
   * Method to show top 100 users
   * 
   * @return array
   */
  public function user_leaderboard() {
    $topUsersTable = $this->User->Vote->find('all',
                                        array(
                                          'fields' => 
                                          array(
                                            'Vote.user_id', 'User.first_name', 'User.last_name','User.id', 
                                            '(User.score -1) * ( User.calls_graded ) AS earned',
                                            'User.score', 'User.calls_graded', 'User.calls_correct',
                                            '(User.calls_correct / User.calls_graded) * 100 as hitrate'  
                                          ),
                                          'conditions' => 
                                            array(
                                              'Vote.is_calculated' => true,
                                              'User.private' => 0,
                                              'User.calls_graded >=' => Configure::read('top_user_votes_graded_limit'),
                                            ),
                                          'group' => 'Vote.user_id',
                                          'order' => 'User.score DESC, User.calls_graded DESC, User.id ASC',
                                          'contains' => 
                                          array(
                                            'User'
                                          ),
                                          'limit' => 100
                                        )
                                      );
     $this->set('topUsersTable', $topUsersTable);  
  }//end user_leaderboard


}//end class
