<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {


  /**
   * Array to hold component.
   *
   * @var void
   */
  public $components = array(
    'Acl',
    'Auth' => array(
      'loginAction' => array(
        'controller' => 'users',
        'action'     => 'home',
        'admin'      => false
      ),
      'authenticate' => array(
        'Form' => array(
          'fields' => array(
            'username' => 'email'
          )
        )
      ),
      'authorize' => 'Controller',
    ),
    'Session',
    'Security' => array(
        'csrfExpires' => '+1 hour',
        'csrfUseOnce' => false
    ),
    'Cookie',
  );


  /**
   * Array to hold helper.
   *
   * @var void
   */
  public $helpers = array(
   'Html',
   'Form',
   'Session',
   'Js',
   'AssetCompress.AssetCompress',
   'PT',
   'Text'
  );

  /**
   * Array to hold helper.
   *
   * @var void
   */
  public $isMobile = '';

  /**
   * method call before any action.
   *
   * return void
   */
    /**
   * Method to auto authenticate user based on remember me cookie
   * This methods checks if the user is authenticated or not. If user is not authenticated
   * and if we find a remember_me cookie, then we will auto authenticate the user
   *
   * @return void
   */
  private function __checkRememberMe() {
   // If user is already authenticated, then return without doing anything
    if ($this->Auth->user('id') || ($this->action == 'login' && $this->request->is('post')) && $this->action != 'logout') {
      return;
    }

    // If remember_me cookie is set then try to authenticate the user with the data stored in the cookie
    if (!empty($_COOKIE['pt_remember_me']) && empty($this->request->data)) {
      $this->request->data['User'] = unserialize(base64_decode($_COOKIE['pt_remember_me']));
      if ($this->Auth->login()) {
        //get parent data from aros table
        $groupInfo = $this->getParentGroup((int)$this->Auth->user('id'));
        if (!empty($groupInfo['parent_group'])) {
          $this->Session->write('Auth.User.userGroup', $groupInfo['parent_group']);
        }
      }
    }
  }//end __checkRememberMe()



  public function beforeFilter() {
    // Check if remember me cookie is set. If set the log the user in
    $this->__checkRememberMe();

    // Call to the function to allow actions to non logged in users.
    $this->allowUser();

    $this->isMobile = $this->request->is('Mobile');
    //debug($this->isMobile);

    //If any body tempering the form, program get stop at that moment
    $this->Security->blackHoleCallback = 'blackhole';

  }//end beforeFilter()


  /**
   * method call before render.
   *
   * return void
   */
  public function beforeRender() {

    $this->set('isMobile', $this->isMobile);

    $option = array(
      'conditions' => array('featured' => 1),
      'contain'    => false
    );
    $this->set('featuredCategory', ClassRegistry::init("Category")->find('all', $option));

  }//end beforeRender()


  /**
   * Function to set the message in session
   *
   * This function uses Session components setFlash message
   *
   * @param string $message Message to be flashed
   * @param string $class   Message class, default is 'success'
   *
   * @return void
   */
  protected function setFlash($message, $class = 'success')
  {
    $option = array('class' => 'alert alert-' . $class);
    $this->Session->setFlash($message);
  }//end setFlash()


  /**
   * Method to authorize user.
   *
   * Method used to check if user is allowed to access current action or not
   * This method is called by auth component's startup() method automatically
   * and contains code to check access using ACL.
   *
   * @return boolean If user is allowed to access current controller/action then return true or return false
   */
  function isAuthorized()
  {
    // Build ARO alias as per user id
    $aroAlias = 'User::' . (int)$this->Auth->user('id');

    // Condition to use to check for ARO existence
    $condition = array('Aro.alias' => $aroAlias);

    // Get logged in user's parent's id
    $parentId = (int)$this->Acl->Aro->field('Aro.parent_id', $condition);

    // If logged in user is of 'Admin' group then allow him everything
    if ($parentId && 'Admin' == $this->Acl->Aro->field('Aro.alias', array('Aro.id' => $parentId))) {
      $this->set('isAdmin', true);
      return true;
    }

    // Build ACO alias
    $acoAlias = $this->name . '::' . $this->action;

    // If ACO does not exist then return true
    if (!$this->Acl->Aco->hasAny(array('Aco.alias' => $acoAlias))) {
      return true;
    }

    // If ARO does not exist then return false
    if (!$this->Acl->Aro->hasAny($condition)) {
      return false;
    }


    // Return true/false according to user's access
    return $this->Acl->check($aroAlias, $acoAlias);
  }//end isAuthorized()


  /**
   * This method returns redirect path for logged in user.
   *
   * @return void
   */
  /*protected function getRedirectPath() {
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      $this->Auth->loginRedirect = array(
        'controller' => 'suggested_pundits',
        'action'     => 'index',
        'admin'      => true,
      );
    } else if ($this->Session->read('Auth.User.userGroup') == 'Pundit') {
      $this->Auth->loginRedirect = array(
        'controller' => 'users',
        'action'     => 'index',
        //'admin'      => true,
      );
    } else if ($this->Session->read('Auth.User.userGroup') == 'General') {
      $this->Auth->loginRedirect = array(
        'controller' => 'pundits',
        'action'     => 'index',
        'admin'      => false
      );
    }
  }//end getRedirectPath()*/


  /**
   * Method getParentGroup()
   *
   * This method is used to get the parent group of the logged in member
   *  and store in session
   *
   * @param integer $userId User id.
   *
   * @return void
   */
  public function getParentGroup($userId = null)
  {
    // Get the member id
    if (empty($userId)) {
        $userId = $this->Auth->user('id');
    }

    // Condition to find parent id of the member
    $conditions = array('Aro.foreign_key' => $userId);
    // Find parent id of logged in user
    $parentId = $this->Acl->Aro->field('parent_id', $conditions);
    // Condition to find parent alias
    $conditions = array('Aro.id' => $parentId);
    // Find parent alias
    return array(
            'parent_id'    => $parentId,
            'parent_group' => $this->Acl->Aro->field('alias', $conditions),
           );
  }//end getParentGroup()


 /**
  * Function to send json response. This function is generally used when an ajax request is made
  *
  * @param array $data Data to be sent in json response
  * @param boolean $jsonHeaders Whether to include json header or not
  *
  * @return void
  */
  protected function sendJson($data, $jsonHeaders = true)
  {
    return new CakeResponse(array(
      'body' => json_encode($data),
      'type' => 'application/json',
    ));
  }//end sendJson()


 /**
  * methods to set the default error handling
  *
  * @param string $e
  *
  * @return void
  */
  /*function appError($e) {
    if ($e->getMessage() == 'Method Not Allowed') {
      $this->redirect(array('controller' => 'users', 'action' => 'home'));
    }
  }//end appError()*/


  /**
   * Method to send emails
   * This is a common method and all emails should be sent out using this method only.
   *
   * Data required in the email template should be set before calling this method.
   *
   * @param array $options See $default options array below.
   *
   * @return boolean True on success
   */
  protected function _sendEmail($options = array())
  {
    // First use email component
    App::uses('CakeEmail', 'Network/Email');
    $email = new CakeEmail();
    $defaults = array(
      'to'          => null,
      'from'        => null,
      'replyTo'     => null,
      'cc'          => array(),
      'bcc'         => array(),
      'subject'     => null,
      'template'    => null,
      'emailFormat' => 'html',
      'attachments' => array(),
      'viewVars'    => null,
    );
    // Merge the passed options with the default ones
    $options = array_merge($defaults, $options);
    // If we don't have a replyTo then set 'from' as 'replyTo'
    if (empty($options['replyTo'])) {
      $options['replyTo'] = $options['from'];
    }
    // Set the options in Email component
    foreach ($options as $option => $value) {
      $email->{$option}($value);
    }
    // Send the email
    return $email->send();
  }//end _sendEmail()


  /**
   * Method for security component error management
   *
   * @param integer $type error type.
   *
   * @return void
   */
  public function blackhole($type) {
    //when program black holed web page exit at that moment
    echo "~`~";
    exit;
    // handle errors.
    //debug($this);
  }//end blackhole()


  /**
   * Function to allow action to user
   *
   * This function is used to allow action to non logged in users.
   *
   * @return void
   */
  private function allowUser()
  {
    // Build ACO alias
    $acoAlias = $this->name . '::' . $this->action;
    // If user is not logged in and current controller/action allowed to 'Anonymous' then allow that action
    if (0 >= (int)$this->Auth->user('id') && $this->Acl->check('Anonymous', $acoAlias)) {
        $this->Auth->allow($this->action);
    }
  }//end allowUser()


}//end class
