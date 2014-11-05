<?php
/**
 * File used as Votes controller
 *
 * This controller is mainly for Votes.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * Votes controller class
 *
 * @category Controller
 * @package  PunditTracker
 */
class VotesController extends AppController
{

  /**
   * Different models used.
   *
   * @var array contains models
   */
  public $uses = array(
    'Vote',
    'User',
    'Call',
    'Category',
  );


  /**
   * Method to add new vote
   *
   * @param string $callId call id
   *
   * @return void
   */
  public function add ($callId = null)
  {
    if ($this->request->is('ajax')) {
      $response['success']   = false;
      $response['message']   = 'Vote not added. Please, try again.';
      //$response['exist']     = false;
      if (!$this->Auth->user('id')) {
        return $this->sendJson($response);
      } else {
        if (isset($this->request->data['Vote']['rate']) && $this->saveVote()) {
          $response['success'] = true;
          //$response['message'] = 'Thank you for the voting!';
          $response['exist']   = true;
        }
      }

      return $this->sendJson($response);
      die;
    } else {
      if (!$this->isMobile) {
        $this->layout = 'iframe';
      } else {
        if (!$this->Session->check('refLocation')) {
          $url = Router::url(array('controller' => 'users', 'action' => 'profile', 'admin' => false));
          if (strpos($this->referer(), 'votes/add') === false && strpos($this->referer(), 'users/login') === false) {
            $url = $this->referer();
          }
          $this->Session->write('refLocation', $url);
        }
      }
      $rateError = null;

      if ($this->request->is('post')) {          
        if (isset($this->request->data['Vote']['rate']) && $this->saveVote()) {
         // $this->setFlash(__('Thank you for voting'));
          if ($this->isMobile) {
            $location = $this->Session->read('refLocation');
            $this->Session->delete('refLocation');
            $this->redirect($location);
          } else {
            $this->render('/Elements/vote_add');
          }
        } else {
          $rateError = 'Please select one';
          $this->set(compact('rateError'));
          //$this->setFlash(__('Vote not added.'), 'error');
        }
      }

      $calls = $this->Vote->getCallForIframe($callId, $this->Auth->user('id'));

      $this->set(compact('calls'));
    }

  }//end add()

  /**
   * Method to save vote
   *
   * @return void
   */
  public function saveVote()
  {
    $this->Vote->contain();
    $userId = $this->Auth->user('id');
    //check is already exist
    $isAlreadyPresent = $this->Vote->isExist($userId, $this->request->data['Vote']['call_id']);

    if (isset ($isAlreadyPresent) && !empty ($isAlreadyPresent)) {
      $this->Vote->id = $isAlreadyPresent['Vote']['id'];
    }
    if (is_array($this->request->data['Vote']['rate'])) {
      $r = key($this->request->data['Vote']['rate']);
      $this->request->data['Vote']['rate'] = $this->request->data['Vote']['rate'][$r];
    }
    $this->request->data['Vote']['user_id'] = $userId; 
    $flag = false;   
    if (isset($this->request->data['Vote']['rate']) && $this->Vote->save($this->request->data)) {
      $flag = true;
    } 
    return $flag;    

  }//end saveVote()



  /**
   * Method to delete 50/50 votes
   *
   * @return void
   */
  public function admin_remove_fiftyfifty() {

    $this->autoRender = false;
    if ($this->Vote->deleteAll(array('rate' => '0.5'), false)) {
      echo "All 50/50 votes has been deleted.<br>";     
    }

  }//end remove_fiftyfifty()
  

}//end class
