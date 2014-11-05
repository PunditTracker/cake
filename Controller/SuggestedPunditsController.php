<?php
/**
 * File used as SuggestedPundits controller
 *
 * This controller is mainly for SuggestedPundits.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * SuggestedPundits controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class SuggestedPunditsController extends AppController
{

  /**
   * different models used
   *
   * @array contains models
   */
  public $uses = array('SuggestedPundit', 'Pundit', 'PunditCategory', 'User', 'Category');

  /**
   * index method
   *
   * @return void
   */
  public function index() {
    $this->SuggestedPundit->recursive = 0;
    $this->set('SuggestedPundit', $this->paginate());
  }//end admin_index()


  /**
   * add method
   *
   * @return void
   */
  public function add() {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }

    if ($this->request->is('post') || $this->request->is('put')) {
      $this->SuggestedPundit->create();
      $this->request->data['SuggestedPundit']['user_id'] = $this->Auth->user('id');

      if ($this->SuggestedPundit->save($this->request->data)) {
        $this->Session->setFlash(__('The Pundit has been Suggested'));

        if ($this->isMobile) {
          $this->redirect('/');
        }
        $this->render('/Elements/iframeclose');
      } else {
        //$this->Session->setFlash(__('Please suggest a Pundit'), 'Flash/error');
      }
    }

    $this->set('categories', $this->Category->generateTreeList(null, null, null, '&nbsp;'));
  }//end admin_add()


  /**
   * add method for new pundit creation
   *
   * @return void
   */
  public function admin_add() {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    }
    $className = 'hide';
    $linkClassName = '';
    if ($this->request->is('post')) {
      //$this->User->create();
      $this->request->data['User']['password'] = randomChars(8);
      if (4 == $this->request->data['User']['filename']['error']) {
        unset($this->request->data['User']['filename']);
      }

      if ($this->SuggestedPundit->saveAndApprovePundit($this->request->data)) {
        $this->setFlash(__('The Pundit has been created.'));
        if ($this->isMobile) {
          $location = $this->Session->read('refLocation');
          $this->Session->delete('refLocation');
          $this->redirect($location);
        }
        $this->render('/Elements/iframeclose');
      } else {
        //$this->setFlash(__('The Pundit could not created, Please try again!'));
      }

      if (isset($this->User->validationErrors['filename'])) {
        $className = 'show';
        $linkClassName = 'hide';
      }
      if (!empty($this->request->data['SuggestedPundit']['id'])) {
        $this->set('suggestedPunditEdit', true);
      }
    }
    $this->set('className', $className);
    $this->set('linkClassName', $linkClassName);
    $this->set('categories', $this->Category->generateTreeList(null, null, null, '&nbsp;'));

  }//end admin_add()


  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function admin_edit($id = null) {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    } else {
      if (!$this->Session->check('refLocation')) {
        $url = Router::url(array('controller' => 'users', 'action' => 'profile', 'admin' => false, $id));
        if (strpos($this->referer(), 'admin/suggested_pundits') !== false) {
          $url = $this->referer();
        }
        $this->Session->write('refLocation', $url);
      }
    }
    $this->SuggestedPundit->id = $id;
    if (!$this->SuggestedPundit->exists()) {
      throw new NotFoundException(__('Invalid Pundit Suggestion'));
    }
    $className = 'hide';
    $linkClassName = '';
    if ($this->request->is('post') || $this->request->is('put')) {

    } else {
      $this->SuggestedPundit->contain();
      $this->request->data = $this->SuggestedPundit->read(null, $id);
    }
    $this->set('categories', $this->Category->generateTreeList(null, null, null, '&nbsp;'));

    $punditName = explode(" ", $this->request->data['SuggestedPundit']['pundit_name'], 2);
    if (isset($punditName[0])) {
      $this->request->data['User']['first_name'] = $punditName[0];
    }
    if (isset($punditName[1])) {
      $this->request->data['User']['last_name'] = $punditName[1];
    }
    $this->request->data['Category']['category_id'] = $this->request->data['SuggestedPundit']['category_id'];
    $this->set('suggestedPunditEdit', true);
    $this->set('className', $className);
    $this->set('linkClassName', $linkClassName);
    $this->render('admin_add');

  }//end admin_edit()


  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function admin_delete($id = null) {
    if (!$this->request->is('ajax')) {
      throw new MethodNotAllowedException();
    }
    $this->SuggestedPundit->id = $id;
    $response['success']   = false;
    $response['message']   = 'Suggested pundit not deleted';
    if ($this->request->is('ajax')) {
      if ($this->SuggestedPundit->delete()) {
        $response['success']   = true;
        $response['message']   = 'Suggested pundit deleted';
      }
    }
    return $this->sendJson($response);
  }//end admin_delete()


  /**
   * method used to display all suggested pundits
   *
   * @return void
   */
  public function admin_index()
  {
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $this->paginate = array(
      'conditions' => array(
        'SuggestedPundit.approve' => 0
      ),
      'order'  => array(
        'SuggestedPundit.created' => 'DESC'
      ),
      'contain' => array(
        'User.first_name',
        'User.last_name',
        'Category.name'
      ),
      'limit' => 20
    );
    $this->set('allSuggestedPundits', $this->paginate('SuggestedPundit'));
  }//end admin_index()


  /**
   * method used to approve suggested pundit
   *
   * @param integer $suggestedPunditId
   *
   * @return void
   */
  public function admin_approve($suggestedPunditId)
  {
    if (!$this->request->is('ajax')) {
      //if request is ajax
      throw new MethodNotAllowedException();
    }
    $this->SuggestedPundit->id = $suggestedPunditId;
    if ($this->request->is('ajax') || $this->request->is('put')) {
      $response['success']   = false;
      $response['message']   = 'Suggested pundit not approved';
      $status = $this->SuggestedPundit->approveSuggestedPundit($suggestedPunditId);
      if ($status) {
        $response['success'] = true;
        $response['message'] = 'Suggested pundit approved';
      }
    }
    return $this->sendJson($response);
    /*} else {
      $this->SuggestedPundit->id = $suggestedPunditId;
      $status = $this->SuggestedPundit->approveSuggestedPundit($suggestedPunditId);
      if ($status) {
        $this->setFlash(__('The Pundit has been suggested and approved'));
        $this->render('/Elements/iframeclose');
      } else {
        $this->setFlash(__('The Pundit has been suggested but not approved'));
      }
    }*/
  }//end admin_approve()


}//end class
