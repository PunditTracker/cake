<?php
/**
 * File used as SuggestedCalls controller
 *
 * This controller is mainly for SuggestedCalls.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * SuggestedCalls controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class SuggestedCallsController extends AppController {


/**
   * method used to display all predictions
   *
   * @return void
   */
  public function admin_index() {

    if($this->request->is('ajax')) {
      $this->layout = null;
    }

    //$this->Session->delete('refLocation');
    $this->paginate = array(
  	  'conditions' => array(
          'approved' => 0
      ),
      'contain' => array(
        'User',
      ),
      'order'  => array(
        'created' => 'DESC'
      ),
      'limit' => 6
    );

    $this->set('calls', $this->paginate());
  }


  public function admin_migrate_unapproved() {
    $this->autoRender = false;
    $calls = $this->SuggestedCall->query("select * from calls where approved = 0;");

    if (!empty($calls)) {
      foreach ($calls as $key => $call) {
        $data = $call['calls'];
        unset($data['id']);
        $userId = $call['calls']['user_id'];

        $user = $this->SuggestedCall->query("select  CONCAT_WS(' ', users.first_name, users.last_name) AS pundit_name  from users where id = $userId;");
        $data['pundit_name'] = $user[0][0]['pundit_name'];

        unset($data['due_date']);
        unset($data['vote_end_date']);
        unset($data['ptvariable']);
        unset($data['boldness']);

        $this->SuggestedCall->create();
        if ($this->SuggestedCall->save($data)) {

          $this->SuggestedCall->User->Call->delete($call['calls']['id']);

        }
      }
    }
  }


  /**
   * delete method
   *
   * @param string $id
   * @return void
   */
  public function admin_delete($id = null) {
    //if request is ajax
    if ($this->request->is('ajax')) {
      //throw new MethodNotAllowedException();
      $this->SuggestedCall->id = $id;
      $response['success']   = false;
      $response['message']   = 'Prediction not deleted';
      if ($this->request->is('ajax')) {
        if ($this->SuggestedCall->delete()) {
          $response['success']   = true;
          $response['message']   = 'Prediction deleted';
        }
      }
      return $this->sendJson($response);
    } else if ($this->request->is('post') || $this->request->is('put')) {
      if (!$this->isMobile) {
        $this->layout = 'iframe';
      }
      //if request is post
      $this->SuggestedCall->id = $id;
      //check if the selected category does not exist
      if (!$this->SuggestedCall->exists()) {
        //throw exception
        throw new NotFoundException(__('Invalid Call'));
      }

      //deleting selected category
      if ($this->SuggestedCall->delete()) {
        //show flash message

        $this->setFlash(__('The Prediction has been deleted.'));
        if ($this->isMobile) {
          $location = $this->Session->read('refLocation');
          $this->Session->delete('refLocation');
          $this->redirect($location);
        }
        $this->set('predictionDeleteStatus', true) ;
        $this->render('/Elements/iframeclose');
      } else {
        $this->setFlash(__('Prediction not deleted'), 'error');
      }
    }
  }//end admin_delete()




    /**
   * add method
   *
   * @param integer $punditId
   *
   * @return void
   */

    /**
   * admin_edit method
   *
   * @param string $id call edit
   * @return void
   */
  public function admin_edit($id = null, $approve = false) {

    if (!$this->isMobile) {
      $this->layout = 'iframe';
    } else {
        if (!$this->Session->check('refLocation')) {
          $url = '/';
          if (strpos($this->referer(), 'admin/suggested_pundits') !== false || strpos($this->referer(), 'admin/SuggestedCalls') !== false) {
            $url = array('controller' => 'SuggestedCalls', 'action' => 'index', 'admin' => true);
          }

          if (strpos($this->referer(), 'categories/view') !== false || strpos($this->referer(), 'pundits/profile') !== false) {
            $url = $this->referer();
          }

          $this->Session->write('refLocation', $url);
        }
      }
    $users = array();
    $vote_end_date = null;
    $punditList = false;
    $this->SuggestedCall->id = $id;
    if (!$this->SuggestedCall->exists()) {
      throw new NotFoundException(__('Invalid Prediction Suggestion'));
    }

    if ($this->request->is('ajax')) {

      $yield = $this->SuggestedCall->getPunditYield($this->request->data['SuggestedCall'], $id);
      return $this->sendJson($yield);

    }

      //$vote_end_date = $this->SuggestedCall->voteEndDate($this->request->data);
    if ($this->request->is('post') || $this->request->is('put')) {

       //$vote_end_date = $this->SuggestedCall->voteEndDate($this->request->data);
      if (!empty($this->request->data['SuggestedCall']['outcome_id']) && ($this->request->data['SuggestedCall']['ptvariable'] != null)) {

        $yield = $this->SuggestedCall->getPunditYield($this->request->data['SuggestedCall'], $id);
        $this->request->data['SuggestedCall']['yield'] = $yield;
        if ($this->request->data['SuggestedCall']['is_calculated']) {
          //calculating boldness
          $boldness = $this->SuggestedCall->getPunditBoldness($this->request->data['SuggestedCall']['outcome_id'], $this->request->data['SuggestedCall']['ptvariable'], $id);
          //setting boldness and yield
          $this->request->data['SuggestedCall']['boldness'] = $boldness;
        }
      } else {
        $this->request->data['SuggestedCall']['yield'] = 0;
      }

      if(!empty($this->request->data['SuggestedCall']['category_id']) && !empty($this->request->data['SuggestedCall']['user_id'])) {
        $this->SuggestedCall->Pundit->punditCategoryAccess($this->request->data['SuggestedCall']['user_id'], $this->request->data['SuggestedCall']['category_id']);
      }




      //code to approve the suggestion
       if($this->request->data['SuggestedCall']['action'] == 'approve') {

          $this->SuggestedCall->set($this->request->data);
          if($this->SuggestedCall->validates()) {

            $this->request->data['SuggestedCall']['approval_time'] = date('Y-m-d H:i:s');
            $this->request->data['SuggestedCall']['approved'] = 1;


            if (isset($this->request->data['SuggestedCall']['id'])) {
              unset($this->request->data['SuggestedCall']['id']);
            }

            if(isset($this->request->data['SuggestedCall']['due_date'])) {
              $this->request->data['SuggestedCall']['due_date'] = date('Y-m-d H:i:s', strtotime($this->request->data['SuggestedCall']['due_date']));
            }

            if(isset($this->request->data['SuggestedCall']['vote_end_date'])) {
              $this->request->data['SuggestedCall']['vote_end_date'] = date('Y-m-d H:i:s', strtotime($this->request->data['SuggestedCall']['vote_end_date']));
            }

            if(isset($this->request->data['SuggestedCall']['created'])) {
              $this->request->data['SuggestedCall']['created'] = date('Y-m-d H:i:s', strtotime($this->request->data['SuggestedCall']['created']));
            }


            if($this->SuggestedCall->User->Call->save($this->request->data['SuggestedCall'])) {

              $this->SuggestedCall->delete();
              $this->setFlash(__('The Prediction has been approved'));

              if ($this->isMobile) {
                $location = $this->Session->read('refLocation');
                $this->Session->delete('refLocation');
                $this->redirect($location);
              }
              $this->render('/Elements/iframeclose');
            }else {

              $this->setFlash(__('The Prediction has not been approved'), 'error');
            }

          }
       }//end of approve function


      if($this->request->data['SuggestedCall']['action'] == 'edit') {

        if ($this->SuggestedCall->save($this->request->data)) {

          $this->setFlash(__('The Prediction has been saved'));
          if ($this->isMobile) {

            $location = $this->Session->read('refLocation');
            $this->Session->delete('refLocation');
            $this->redirect($location);
          }

          $this->render('/Elements/iframeclose');
        } else {
            $punditList = true;
        }
      }
      } else {
          $this->SuggestedCall->contain();
          $this->request->data = $this->SuggestedCall->read(null, $id);
          $punditList = true;
      }

      if ($punditList) {
        if (!empty($this->request->data['SuggestedCall']['category_id'])) {

          $query = "SELECT users.id,
          CONCAT_WS(' ', users.first_name, users.last_name) AS pundits_name
          FROM `pundit_categories`, `pundits`, `users`
          WHERE
          pundits.id = pundit_categories.pundit_id
          AND
          users.id = pundits.user_id
          AND
          category_id='".$this->request->data['SuggestedCall']['category_id']."'
          ORDER BY  `pundits_name` ASC";

          $pundits = $this->SuggestedCall->Pundit->query($query);

          foreach($pundits as $pundit) {
          $users[$pundit['users']['id']] = $pundit[0]['pundits_name'];
        }
        $this->set('users', $users);
      } //end if
    }

    $outcomes = $this->SuggestedCall->Outcome->find('list', array(
      'fields' => array('id', 'title'),
      'conditions' => array('id NOT' => '3'),
      'order' => 'id',
      )
    );
    $predictionId = $id;
    $categories = $this->SuggestedCall->Category->generateTreeList(null, null, null, '&nbsp;');
    $this->set(compact('categories', 'outcomes', 'predictionId'));

  }//end of edit



  public function add($punditId = null) {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    } else {
      if (!$this->Session->check('refLocation')) {
        $url = Router::url(array('controller' => 'users', 'action' => 'profile', 'admin' => false));
        if (strpos($this->referer(), 'SuggestedCalls/add') === false && strpos($this->referer(), 'users/login') === false) {
          $url = $this->referer();
        }
        $this->Session->write('refLocation', $url);
      }
    }
    $users = array();
    $categoryId = null;
    if ($this->request->is('post') || $this->request->is('put')) {
      if(!empty($this->request->data['SuggestedCall']['category_id']) && !empty($this->request->data['SuggestedCall']['user_id'])) {
        $this->Pundit->punditCategoryAccess($this->request->data['SuggestedCall']['user_id'], $this->request->data['SuggestedCall']['category_id']);
      }
      $this->SuggestedCall->Pundit->PunditCategory->contain();
      //getting pundit id
      $punditId = $this->SuggestedCall->Pundit->field('id',
        array(
         // 'Pundit.user_id' => $this->request->data['Call']['user_id']
       )
      );

      //saving prediction
      $this->SuggestedCall->create();
      $this->request->data['SuggestedCall']['suggested_by_user_id'] = $this->Auth->user('id');
      //$this->request->data['Call']['category_id'] = $categoryId['PunditCategory']['category_id'];
      //unset($this->Call->validate['created']);
      if ($this->SuggestedCall->save($this->request->data)) {
        $this->setFlash(__('The Prediction has been Suggested'));
        if ($this->isMobile) {
          $location = $this->Session->read('refLocation');
          $this->Session->delete('refLocation');
          $this->redirect($location);
        } else {
          $this->render('/Elements/iframeclose');
        }
      }
    }

  }







}
