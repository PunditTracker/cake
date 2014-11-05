<?php
/**
 * File used as Pundits controller
 *
 * This controller is mainly for Pundits.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * Pundits controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class PunditsController extends AppController
{

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
  public $uses = array('Pundit', 'User', 'Call', 'Category', 'CallDummy', 'Outcome', 'Vote');


  /**
   * Method is used to retrieve all Pundits
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function index($categoryId = null)
  {
    $categoriesWithPundits = $this->Pundit->Category->find('all', array('contain' => 'Pundit'));

    foreach ($categoriesWithPundits as $key => $categoryWithPundits) {
      $userIds = array_unique(Set::extract('/user_id', $categoryWithPundits['Pundit']));
      unset($categoriesWithPundits[$key]['Pundit']);
      $this->Pundit->User->bindModel(array('hasOne' => array('Pundit')));
      $params = array(
        'conditions' => array('User.id' => $userIds),
        'contain' => array('Pundit.score', 'Pundit.calls_graded'),
        'fields' => array(
          'User.id',
          'User.first_name',
          'User.last_name',
          'User.slug'
        ),
        'order' => array('User.last_name' => 'asc')
      );
      $categoriesWithPundits[$key]['User'] = $this->Pundit->User->find('all', $params);
    }

    $this->set('allCategoriesData', $categoriesWithPundits);
  }//end index()


  /**
   * Method is used to view pundit profile
   *
   * @param integer $punditId pundit id
   *
   * @return void
   */
  public function profile($slug = null)
  {
    $slugById = $this->User->field('slug', array('id' => $slug));
    if ($slugById !== false) {
      $this->redirect(array('action' => 'profile', $slugById), 301);
    }

    $users = $this->User->findBySlug($slug);
    $punditId = $users['User']['id'];
    if (false == $this->Pundit->User->validUser($punditId, Configure::read('pundit_group_id'))) {
      $this->redirect(array('controller' => 'users', 'action' => 'home'));
    }

    if (empty($punditId)) {
      throw new MethodNotAllowedException();
    }
    $this->Session->delete('refLocation');
    if (!empty($this->params->params['named']['archive'])) {
      $this->setAction('live_archive_call', $punditId);
    } else {
      $this->setAction('live_archive_call', $punditId);
    }
  }//end profile()

   /**
   * Method is used to view pundit profile all calls with pagination
   *
   * @param integer $punditId pundit id
   *
   * @return void
   */
  public function profile_calls($slug = null)
  {
    $slugById = $this->User->field('slug', array('id' => $slug));
    if ($slugById !== false) {
      $this->redirect(array('action' => 'profile', $slugById), 301);
    }

    $users = $this->User->findBySlug($slug);
    $punditId = $users['User']['id'];
    if (false == $this->Pundit->User->validUser($punditId, Configure::read('pundit_group_id'))) {
      $this->redirect(array('controller' => 'users', 'action' => 'home'));
    }

    if (empty($punditId)) {
      throw new MethodNotAllowedException();
    }
    $this->Session->delete('refLocation');
    if (!empty($this->params->params['named']['archive'])) {
      $this->setAction('archive_call', $punditId);
    } else {
      $this->setAction('live_call', $punditId);
    }
  }//end profile_calls()


  /**
   * Method is used to view pundit live call
   *
   * @param integer $punditId pundit id
   *
   * @return void
   */
  public function live_call($punditId = null)
  {
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $selectedTab = 'liveCalls';
    $option  = array(
      'conditions' => array(
        'Pundit.user_id' => $punditId
      ),
      'contain' => 'User'
    );
    $userInfo = $this->Pundit->find('first', $option);
    $option = array(
      'user_id' => $punditId,
    );
    $userInfo['tracked'] = $this->Call->field('min(created)', array('user_id' => $punditId));
    //$userOutcomeData = $this->Call->getVerticalCallOutcome($this->Auth->user('id'), $punditId);
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('userInfo', 'punditId', 'selectedTab', 'outcomes'));
    $userId = ($this->Auth->user('id') ? $this->Auth->user('id') : 0);
    $options = array(
      'conditions' => array(
        'Call.user_id' => $punditId,
        'approved' => 1,
        'OR' => array(
          //'vote_end_date >=' => date('Y-m-d H:i:s'),
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
      ),
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'Vote.user_id' => array($userId, NULL),
          ),
          //'order' => 'FIELD(Vote.user_id, "", '.$userId.') ASC',
        ),
        'Category'
      ),
      'fields' => array(
        '*',
        '(CASE
          WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()
            THEN 1              /***** Have not voted yet, but able to vote *******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date > NOW()
            THEN 2              /***** Have voted and able not change ******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date < NOW()
            THEN 3              /***** Have voted and not able to change******/
          ELSE 4                /***** Not able to vote on *******/
        END) AS priority',
      ),
      'limit' => 20,
    );

    /*$options['order'] = 'CASE WHEN Vote.user_id IS NULL
      AND Call.vote_end_date > NOW()
      THEN 0 WHEN Vote.user_id IS NOT NULL
      THEN 1 ELSE 2
      END, Call.vote_end_date DESC, Call.created ASC';*/

    /*$options['order'] = 'CASE
      WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()  /***** Have not voted yet, but able to vote *******
        THEN Call.vote_end_date
      WHEN Vote.user_id IS NOT NULL                             /***** Have voted ******
        THEN Call.vote_end_date
      WHEN Call.vote_end_date <= NOW()                          /***** Not able to vote on *******
        THEN Call.created
      END DESC';*/

    $options['order'] = 'priority ASC,
    CASE WHEN priority != 4
      THEN Call.vote_end_date
    END ASC,
    CASE WHEN priority = 4
      THEN Call.created
    END DESC';

    $this->paginate = $options;
    $this->Call->unbindModel(
      array('hasMany' => array('Vote'))
    );
    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey' => 'user_id',
            'type' => 'inner',
          ),
        ),
        'hasOne' => array('Vote')
      ), false
    );

    $canonicalUrl = array(
      'action' => 'profile',
      $userInfo['User']['slug'],
    );
    $userCategory = classRegistry::init('pundit_categories')->find('all', 
                                                                    array(
                                                                        'fields' => array(
                                                                          'pundit_categories.category_id', 'Category.parent_id', 'Category.id'),
                                                                       'joins' => array(
                                                                          array(
                                                                              'table' => 'categories',
                                                                              'alias' => 'Category',
                                                                              'type' => 'INNER',
                                                                              'feild' => 'parent_id',
                                                                              'conditions' => array(
                                                                                  'Category.id = pundit_categories.category_id'
                                                                              )
                                                                          )
                                                                      ),
                                                                        'conditions' => 
                                                                      array(
                                                                        'pundit_id' => $userInfo['Pundit']['id']
                                                                      ),
                                                                    )
                                                                  ); 
     $msg = '';        
    foreach ($userCategory as $key => $value) {
     if ($value['pundit_categories']['category_id'] == 3 || $value['Category']['parent_id'] == 3) {
          $msg = "Picks &amp; Predictions";
      }
    }
    $categoryId = $userCategory[0]['pundit_categories']['category_id'];
    $topPundit = $this->Category->getTopPundit($categoryId, 3);
    $this->set(compact('canonicalUrl', 'msg', 'topPundit'));
    $this->set('userProfileLiveData', $this->paginate('Call'));
    $this->set("title_for_layout", "{$userInfo['User']['first_name']} {$userInfo['User']['last_name']}'s ".(!empty($msg) ? $msg : "Predictions &amp; Picks")."");
    $this->set('metaDescription', "Track record of {$userInfo['User']['first_name']} {$userInfo['User']['last_name']}’s predictions. Can you do better?");

  }//end live_call()


  /**
   * Method is used to view pundit archive call
   *
   * @param integer $punditId pundit id
   *
   * @return void
   */
  public function archive_call($punditId = null)
  {
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $selectedTab = 'archiveCalls';
    $option  = array(
      'conditions' => array(
        'Pundit.user_id' => $punditId
      ),
      'contain' => 'User'
    );
    $userInfo = $this->Pundit->find('first', $option);
    $userInfo['tracked'] = $this->Call->field('min(created)', array('user_id' => $punditId));
    $this->paginate = array(
      'conditions' => array(
        'CallDummy.user_id' => $punditId,
        'approved' => 1,
        'outcome_id NOT' => null,
        //'vote_end_date <' => date('Y-m-d H:i:s')
      ),
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          )
        ),
        'Category'
      ),
      'order' => 'CallDummy.created DESC',
      'limit' => 20,
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
      $userInfo['User']['slug'],
      //'archive' => true,
    );

     $userCategory = classRegistry::init('pundit_categories')->find('all', 
                                                                    array(
                                                                        'fields' => array(
                                                                          'pundit_categories.category_id', 'Category.parent_id', 'Category.id'),
                                                                       'joins' => array(
                                                                          array(
                                                                              'table' => 'categories',
                                                                              'alias' => 'Category',
                                                                              'type' => 'INNER',
                                                                              'feild' => 'parent_id',
                                                                              'conditions' => array(
                                                                                  'Category.id = pundit_categories.category_id'
                                                                              )
                                                                          )
                                                                      ),
                                                                        'conditions' => 
                                                                      array(
                                                                        'pundit_id' => $userInfo['Pundit']['id']
                                                                      ),
                                                                    )
                                                                  );
    $msg = '';
    foreach ($userCategory as $key => $value) {
      if ($value['pundit_categories']['category_id'] == 3 || $value['Category']['parent_id'] == 3) {
          $msg = "Picks &amp; Predictions";
      }
    }
    $categoryId = $userCategory[0]['pundit_categories']['category_id'];
    $this->set(compact('canonicalUrl'));
    $topPundit = $this->Category->getTopPundit($categoryId, 3);
    $this->set('userProfileArchievesData', $this->paginate('CallDummy'));
    $this->set("title_for_layout", "{$userInfo['User']['first_name']} {$userInfo['User']['last_name']}'s ".(!empty($msg) ? $msg : "Predictions &amp; Picks")."");
    $this->set('metaDescription', "Track record of {$userInfo['User']['first_name']} {$userInfo['User']['last_name']}’s predictions. Can you do better?");
    //$userOutcomeData = $this->Call->getVerticalCallOutcome($this->Auth->user('id'), $punditId);
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('userInfo', 'punditId', 'selectedTab', 'outcomes', 'msg', 'topPundit'));

  }//end archive_call()

  /**
   * Method is used to view pundit live and archive call without pagination
   *
   * @param integer $punditId pundit id
   *
   * @return void
   */
  public function live_archive_call($punditId = null)
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
    $selectedTab = 'liveCalls';
    $option  = array(
      'conditions' => array(
        'Pundit.user_id' => $punditId
      ),
      'contain' => 'User'
    );
    $userInfo = $this->Pundit->find('first', $option);
    $option = array(
      'user_id' => $punditId,
    );
    $userInfo['tracked'] = $this->Call->field('min(created)', array('user_id' => $punditId));
    //$userOutcomeData = $this->Call->getVerticalCallOutcome($this->Auth->user('id'), $punditId);
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('userInfo', 'punditId', 'selectedTab', 'outcomes'));
    $userId = ($this->Auth->user('id') ? $this->Auth->user('id') : 0);
    $options = array(
      'conditions' => array(
        'Call.user_id' => $punditId,
        'approved' => 1,
        'OR' => array(
          //'vote_end_date >=' => date('Y-m-d H:i:s'),
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
      ),
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'Vote.user_id' => array($userId, NULL),
          ),
          //'order' => 'FIELD(Vote.user_id, "", '.$userId.') ASC',
        ),
        'Category'
      ),
      'fields' => array(
        '*',
        '(CASE
          WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()
            THEN 1              /***** Have not voted yet, but able to vote *******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date > NOW()
            THEN 2              /***** Have voted and able not change ******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date < NOW()
            THEN 3              /***** Have voted and not able to change******/
          ELSE 4                /***** Not able to vote on *******/
        END) AS priority',
      ),
      'limit' => 10,
    );

    /*$options['order'] = 'CASE WHEN Vote.user_id IS NULL
      AND Call.vote_end_date > NOW()
      THEN 0 WHEN Vote.user_id IS NOT NULL
      THEN 1 ELSE 2
      END, Call.vote_end_date DESC, Call.created ASC';*/

    /*$options['order'] = 'CASE
      WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()  /***** Have not voted yet, but able to vote *******
        THEN Call.vote_end_date
      WHEN Vote.user_id IS NOT NULL                             /***** Have voted ******
        THEN Call.vote_end_date
      WHEN Call.vote_end_date <= NOW()                          /***** Not able to vote on *******
        THEN Call.created
      END DESC';*/

    $options['order'] = 'priority ASC,
    CASE WHEN priority != 4
      THEN Call.vote_end_date
    END ASC,
    CASE WHEN priority = 4
      THEN Call.created
    END DESC';

    $this->paginate = $options;
    $this->Call->unbindModel(
      array('hasMany' => array('Vote'))
    );
    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey' => 'user_id',
            'type' => 'inner',
          ),
        ),
        'hasOne' => array('Vote')
      ), false
    );

    $canonicalUrl = array(
      'action' => 'profile',
      $userInfo['User']['slug'],
    );
     $userCategory = classRegistry::init('pundit_categories')->find('all', 
                                                                    array(
                                                                        'fields' => array(
                                                                          'pundit_categories.category_id', 'Category.parent_id', 'Category.id'),
                                                                       'joins' => array(
                                                                          array(
                                                                              'table' => 'categories',
                                                                              'alias' => 'Category',
                                                                              'type' => 'INNER',
                                                                              'feild' => 'parent_id',
                                                                              'conditions' => array(
                                                                                  'Category.id = pundit_categories.category_id'
                                                                              )
                                                                          )
                                                                      ),
                                                                        'conditions' => 
                                                                      array(
                                                                        'pundit_id' => $userInfo['Pundit']['id']
                                                                      ),
                                                                    )
                                                                  );
    $msg ="";
    foreach ($userCategory as $key => $value) { 
      if ($value['pundit_categories']['category_id'] == 3 || $value['Category']['parent_id'] == 3) {
          $msg = "Picks &amp; Predictions";
      }
    }
    $categoryId = $userCategory[0]['pundit_categories']['category_id'];
    $topPundit = $this->Category->getTopPundit($categoryId, 3);
    
    //$this->set(compact('canonicalUrl'));
    $this->set('userProfileLiveData', $this->paginate('Call'));
    $this->set("title_for_layout", "{$userInfo['User']['first_name']} {$userInfo['User']['last_name']}'s ".(!empty($msg) ? $msg : "Predictions &amp; Picks")."");
    $this->set('metaDescription', "Track record of {$userInfo['User']['first_name']} {$userInfo['User']['last_name']}’s predictions. Can you do better?");
    $this->set(compact('msg', 'topPundit'));
 
    $selectedTab = 'archiveCalls';
    $option  = array(
      'conditions' => array(
        'Pundit.user_id' => $punditId
      ),
      'contain' => 'User'
    );
    $userInfo = $this->Pundit->find('first', $option);
    $userInfo['tracked'] = $this->Call->field('min(created)', array('user_id' => $punditId));
    $this->paginate = array(
      'conditions' => array(
        'CallDummy.user_id' => $punditId,
        'approved' => 1,
        'outcome_id NOT' => null,
        //'vote_end_date <' => date('Y-m-d H:i:s')
      ),
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          )
        ),
        'Category'
      ),
      'order' => 'CallDummy.created DESC',
      'limit' => 10,
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
      $userInfo['User']['slug'],
      'archive' => true,
    );
    //$this->set(compact('canonicalUrl'));

    
    $this->set('userProfileArchievesData', $this->paginate('CallDummy'));
    $this->set("title_for_layout", "{$userInfo['User']['first_name']} {$userInfo['User']['last_name']}'s ".(!empty($msg) ? $msg : "Predictions &amp; Picks")."");
    $this->set('metaDescription', "Track record of {$userInfo['User']['first_name']} {$userInfo['User']['last_name']}’s predictions. Can you do better?");
    //$userOutcomeData = $this->Call->getVerticalCallOutcome($this->Auth->user('id'), $punditId);
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('userInfo', 'punditId', 'selectedTab', 'outcomes'));
    $this->set('live_archive_call','live_archive_call');
  }//end live_archive_call()


  /**
   * Method is used to view pundit history
   *
   * @param integer $punditId pundit id
   *
   * @return void
   */
  public function history($punditId = null)
  {
    $option  = array(
      'conditions' => array(
        'User.id' => $punditId
      ),
      'contain' => false
    );
    $userInfo = $this->User->find('first', $option);

    if (!empty($punditId)) {
      $conditions['Call.user_id'] = $punditId;

    }

    $this->paginate = array(
      'conditions' => $conditions,
      'contain' => array(
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          )
        )
      ),
      'limit' => 20,
      'order' => 'vote_end_date asc'
    );
    $punditHistory = $this->paginate('Call');
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('userInfo','punditHistory','punditId', 'outcomes'));
  }//end history()


  /**
   * Method is used to return categor list of any pundit
   *
   * @param integer $userId user id
   *
   * @return void
   */
  public function categoryList($userId = null)
  {
    $categories = array();
    $option = array(
      'conditions' => array(
        'Pundit.user_id' => $userId,
      ),
      'contain' => 'Category'
    );
    $dataRow = $this->Pundit->find('first', $option);
    $i = 0;
    if (!empty($dataRow['Category'])) {
      foreach($dataRow['Category'] as $category) {
        $categories[$category['id']] = $category['name'];
      }
    }

    return $this->sendJson($categories);

  }//end categoryList()


  /**
   * Method is used to return pundits list of any category
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function punditList($categoryId = null)
  {
    $punditList = array();

    if (empty ($categoryId)) {
      //if no category is selected
      /*$pundits = $this->Pundit->find(
        'all',
        array(
          'contain' => 'User',
          'order' => array('User.first_name' => 'ASC')
        )
      );
      foreach ($pundits as $pundit) {
        $punditList[$pundit['Pundit']['user_id']] = $pundit['User']['first_name']. ' ' .$pundit['User']['last_name'];
      }  */

    } else {
      //if any category is selected
      $query = "SELECT users.id,
        CONCAT_WS(' ', users.first_name, users.last_name) AS pundit_name
        FROM `pundit_categories`, `pundits`, `users`
        WHERE
        pundits.id = pundit_categories.pundit_id
        AND
        users.id = pundits.user_id
        AND
        category_id='".$categoryId."'
        ORDER BY  `pundit_name` ASC";

      $pundits = $this->Pundit->query($query);

      foreach($pundits as $pundit) {
        $punditList[$pundit['users']['id']] = $pundit[0]['pundit_name'];
      }
    }
    return $this->sendJson($punditList);
  }//end punditList()


  /**
   * method used to edit profile info
   *
   * @param integer $id user id basically user group is pundit
   *
   * @return void
   */
  public function admin_edit_info($id = null)
  {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid User'));
    }
    $this->set('punditId', $id);
    $className = 'hide';
    $linkClassName = '';
    if ($this->request->is('post') || $this->request->is('put')) {
      if (4 == $this->request->data['User']['filename']['error']) {
        unset($this->request->data['User']['filename']);
      }

      $option = array('user_id' =>  $this->request->data['User']['id']);
      $pundit['Pundit']['id'] = $this->Pundit->field('id', $option);
      $pundit['Pundit']['featured'] = $this->request->data['User']['featured'];

      unset($this->User->validate['email']);
      if ($this->User->save($this->request->data) && $this->Pundit->save($pundit)) {
        if ($this->Pundit->PunditCategory->deleteAll(array('pundit_id' => $pundit['Pundit']['id']))) {
          foreach ($this->request->data['Category']['Category'] as $key => $categoryId) {

            $punditc['pundit_id'] = $pundit['Pundit']['id'];
            $punditc['category_id'] = $categoryId;
            $this->Pundit->PunditCategory->create();
            $this->Pundit->PunditCategory->save($punditc);
          }
        }

        $this->setFlash(__('The Pundit information has been updated.'));
        if ($this->isMobile) {
          $this->redirect(array('action' => 'profile', $id, 'admin' => false));
        }
        $this->render('/Elements/iframeclose');
      } else {
        //$this->setFlash(__('The Pundit information could not updated. Please, try again.'), 'error');
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
      $option = array('user_id' =>  $this->request->data['User']['id']);

      $pundits = $this->Pundit->field('featured', $option);
      $this->request->data['User']['featured'] = $pundits;
    }

    $option = array('user_id' =>  $this->request->data['User']['id']);
    $punditId = $this->Pundit->field('id', $option);
    $punditCategory = $this->Pundit->PunditCategory->find('list', array('fields' => array('category_id'), 'conditions' => array('pundit_id' => $punditId)));
    $this->request->data['Category']['Category'] = $punditCategory;
    $this->set('categories', $this->Category->generateTreeList(null, null, null, '&nbsp;'));
  }//end admin_edit_info()


  /**
   * Method is used to delete Pundit
   *
   * @param integer $userId is a Pundit id
   *
   * @return void
   */
  public function admin_delete($userId = null)
  {

    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }

    $this->User->id = $userId;
    //check if the selected category does not exist
    if (!$this->User->exists()) {
      //throw exception
      throw new NotFoundException(__('Invalid Pundit'));
    }

    $option = array('Pundit.user_id' => $userId);
    $punditId = $this->Pundit->field('id', $option);

    $options = array(
      'conditions' => array(
        'Vote.call_id' => $this->Call->find(
          'list', array(
            'conditions' => array('Call.user_id' => $userId)
          )
        )
      ),
      'fields'     => array('Vote.user_id'),
    );
    $votedUserId = $this->Vote->find('list', $options);

    //deleting selected category
    if ($this->User->delete($userId, false) && $this->Pundit->delete($punditId)
      && $this->Call->deleteAll(array('Call.user_id' => $userId), true)) {

      if (!empty($votedUserId)) {
        foreach($votedUserId as $userId) {
          $this->Vote->refreshUserScore($userId);
        }
      }

      //show flash message
      $this->setFlash(__('Pundit deleted'), 'success');
      //redirect page
      if ($this->isMobile) {
        $this->redirect('/');
      }
      $this->set('punditDelete', true);
      $this->render('/Elements/Pundit/after_delete');
    } else {
      $this->setFlash(__('Pundit was not deleted'), 'error');
    }
  }//end admin_delete()


  /**
   * Method is used to update all Pundit score
   *
   * @return void
   */
  function admin_score_update() {
    set_time_limit(60);
    $this->layout = false;
    $this->autoRender = false;

    $punditIds = $this->Pundit->find('list', array('fields' => array('id', 'user_id')));

    if ($punditIds == '0') {
      print("Pundit not found. Please try again after some time");
      exit;
    }

    $countPundit = count($punditIds);

    $i = $j = 0;
    foreach($punditIds as $keyP => $punditId) {
      $i++;
      //saving avg score in pundits table
      $punditData['score'] = $this->Call->punditScore($punditId);
      //saving avg boldness in pundits table
      $punditData['avg_boldness'] = $this->Call->punditBoldness($punditId);
      //saving avg score in pundits table
      $punditData['calls_graded'] = $this->Call->punditCallsGraded($punditId);
      //saving avg score in pundits table
      $punditData['calls_correct'] = $this->Call->punditCorrectCall($punditId);

      $this->Pundit->id = $keyP;
      if ($this->Pundit->save($punditData)) {
        $j++;
        print("Pundit score has been updated for id #$punditId").'</br>';
      }

    }

    print("<strong>Total Number Of Pundit :#$countPundit ");
    print("Total Number Of Iteration :#$i ");
    print("Total Number Of Success :#$j ");
    print("Number Of Fails :#".($i - $j)." </strong>");

  }//end admin_score_update()


  /**
   * Method is used to delete Pundit
   *
   * @param integer $userId user id
   *
   * @return void
   */
  function pundit_info($userId = null) {

    $userId = !empty($userId) ? $userId : $this->Auth->user('id');
    $option  = array(
      'conditions' => array(
        'Pundit.user_id' => $userId
      ),
      'contain' => 'User'
    );
    $userInfo = $this->Pundit->find('first', $option);
    $userInfo['tracked'] = $this->Call->field('min(created)', array('user_id' => $userId));
    $this->set(compact('userInfo'));
    $this->render('/Elements/Pundit/pundit_profile_info');
  }//end pundit_info()


  function update_pundits_calls($categoryId = 3) {
    $catOptions = array(
      'contain' => array('Pundit' => array('id', 'user_id')),
      'conditions' => array('parent_id' => $categoryId),
      'fields' => array('id', 'parent_id'),
    );
    $categories = $this->Pundit->Category->find('all', $catOptions);
    foreach ($categories as $key => $category) {
      if (!empty($category['Pundit'])) {
        foreach ($category['Pundit'] as $key => $pundit) {

          $callsOptions = array(
            'contain' => false,
            'conditions' => array('user_id' => $pundit['user_id']),
          );
          $query = "UPDATE `calls` SET
            category_id = {$category['Category']['id']}
            WHERE
            user_id = {$pundit['user_id']} AND
            category_id = {$categoryId}
          ";
          if ($this->Pundit->query($query)) {
            echo "*";
          } else {
            echo "x";
          }
        }
      }
    }
    exit;
  }


}//end class
