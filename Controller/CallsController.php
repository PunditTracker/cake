<?php
/**
 * File used as call or prediction controller
 *
 * This controller is mainly for Calls.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * Call controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class CallsController extends AppController 
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
  public $uses = array('Call', 'CallDummy', 'Outcome', 'Vote', 'Pundit');


  /**
   * method used to display all predictions
   *
   * @return void
   */
  public function admin_index()
  {  
    $this->Session->delete('refLocation');   
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
    //all pundits returns
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
    $this->set('calls', $this->paginate());
  }//end admin_index()
      
  
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
      $this->Call->id = $id;
      $response['success']   = false;
  	  $response['message']   = 'Prediction not deleted';
      if ($this->request->is('ajax')) {
        if ($this->Call->delete()) {
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
      $this->Call->id = $id;
      //check if the selected category does not exist
      if (!$this->Call->exists()) {
        //throw exception
        throw new NotFoundException(__('Invalid Call'));
      }

      $callPunditId = $this->Call->field('user_id', array('id' => $id));
      $this->Call->callPunditId = $callPunditId;
      $votedUserList = $this->Call->Vote->find('list', array('fields' => array('Vote.user_id'), 'conditions' => array('Vote.call_id' => $id)));

      $this->Call->votedUserId = $votedUserList;
      //deleting selected category
      if ($this->Call->delete()) {
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
  public function add($punditId = null) {

    if (!$this->isMobile) {
      $this->layout = 'iframe';   
    } else {
      if (!$this->Session->check('refLocation')) {
        $url = Router::url(array('controller' => 'users', 'action' => 'profile', 'admin' => false));
        if (strpos($this->referer(), 'calls/add') === false && strpos($this->referer(), 'users/login') === false) {
          $url = $this->referer();
        }
        $this->Session->write('refLocation', $url);
      }
    }
    $users = array(); 
    $categoryId = null;
    if ($this->request->is('post') || $this->request->is('put')) {     
      if(!empty($this->request->data['Call']['category_id']) && !empty($this->request->data['Call']['user_id'])) {
        $this->Pundit->punditCategoryAccess($this->request->data['Call']['user_id'], $this->request->data['Call']['category_id']);
      } 
      $this->Call->Pundit->PunditCategory->contain();
      //getting pundit id
     /* $punditId = $this->Call->Pundit->field('id',
        array(
          'Pundit.user_id' => $this->request->data['Call']['user_id']
        )
      );*/    
      //saving prediction
      $this->Call->User->SuggestedCall->create();     
      $this->request->data['SuggestedCall']['suggested_by_user_id'] = $this->Auth->user('id');
      //$this->request->data['Call']['category_id'] = $categoryId['PunditCategory']['category_id'];     
      
      if(isset($this->data['SuggestedCall']['created'])) {
      $this->request->data['SuggestedCall']['created'] = date('Y-m-d H:i:s', strtotime($this->data['SuggestedCall']['created']));
    }
      if ($this->Call->User->SuggestedCall->save($this->request->data)) {
        $this->setFlash(__('The Prediction has been Suggested'));   
        if ($this->isMobile) {
          $location = $this->Session->read('refLocation');
          $this->Session->delete('refLocation');
          $this->redirect($location);
        } else {
          $this->render('/Elements/iframeclose');        
        }
      } /*else {
        if (!empty($this->request->data['Call']['category_id'])) {
          $query = "SELECT users.id, 
            CONCAT_WS(' ', users.first_name, users.last_name) AS pundit_name 
            FROM `pundit_categories`, `pundits`, `users` 
            WHERE 
            pundits.id = pundit_categories.pundit_id 
            AND 
            users.id = pundits.user_id 
            AND 
            category_id='".$this->request->data['Call']['category_id']."' 
            ORDER BY  `pundit_name` ASC";

          $pundits = $this->Pundit->query($query);

          foreach($pundits as $pundit) {
            $users[$pundit['users']['id']] = $pundit[0]['pundit_name'];
          }
          $this->set('users', $users);
        } //end if */
        
      }  
      /* $categories = $this->Call->Category->generateTreeList(null, null, null, '&nbsp;');
          $this->set(compact('punditId', 'categories')); */ 
    } 
    
    
  //end add()
 

  /**
   * admin_add method
   *
   * @param integer $currentPunditId 
   *
   * @return void
   */
  public function admin_add($currentPunditId = null) {
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    } else {
      if (!$this->Session->check('refLocation')) {
        $url = Router::url(array('controller' => 'users', 'action' => 'profile', 'admin' => false));
        if (strpos($this->referer(), 'calls/add') === false && strpos($this->referer(), 'users/login') === false) {
          $url = $this->referer();
        }
        $this->Session->write('refLocation', $url);
      }
    }
    $categoryId = null;
    $users = array(); 
    
    if ($this->request->is('ajax')) {
      $yield = $this->Call->getPunditYield($this->request->data['Call']);
      return $this->sendJson($yield);     
    }       
    
    if ($this->request->is('post') || $this->request->is('put')) {  
      
      if (!empty($this->request->data['Call']['outcome_id']) && ($this->request->data['Call']['ptvariable'] != null)) {
        $yield = $this->Call->getPunditYield($this->request->data['Call']);
        $this->request->data['Call']['yield'] = $yield;
        if ($this->request->data['Call']['is_calculated']) {
          //calculating boldness
          $boldness = $this->Call->getPunditBoldness($this->request->data['Call']['outcome_id'], $this->request->data['Call']['ptvariable']);
          //setting boldness and yield          
          $this->request->data['Call']['boldness'] = $boldness;
        }        
      }
      
      if(!empty($this->request->data['Call']['category_id']) && !empty($this->request->data['Call']['user_id'])) {
        $this->Pundit->punditCategoryAccess($this->request->data['Call']['user_id'], $this->request->data['Call']['category_id']);
      } 
      
      //saving prediction
      $this->Call->create();     
      $this->request->data['Call']['suggested_by_user_id'] = $this->Auth->user('id');
      $this->request->data['Call']['approved'] = 1;
      $this->request->data['Call']['approval_time'] = date('Y-m-d H:i:s');
      //unset($this->Call->validate['created']);
      if ($this->Call->save($this->request->data)) {
        $this->setFlash(__('The Prediction has been saved'));
        if ($this->isMobile) {
          $location = $this->Session->read('refLocation');
          $this->Session->delete('refLocation');
          $this->redirect($location);
        } else {
          $this->render('/Elements/iframeclose');
        } 
      } else {
        if (!empty($this->request->data['Call']['category_id'])) {
          $query = "SELECT users.id, 
            CONCAT_WS(' ', users.first_name, users.last_name) AS pundit_name 
            FROM `pundit_categories`, `pundits`, `users` 
            WHERE 
            pundits.id = pundit_categories.pundit_id 
            AND 
            users.id = pundits.user_id 
            AND 
            category_id='".$this->request->data['Call']['category_id']."' 
            ORDER BY  `pundit_name` ASC";

          $pundits = $this->Pundit->query($query);

          foreach($pundits as $pundit) {
            $users[$pundit['users']['id']] = $pundit[0]['pundit_name'];
          }
          $this->set('users', $users);
        } //end if
      } // end else
    } 
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
  
    $formHeading = 'Add Prediction';
    $this->set('categories', $this->Call->Category->generateTreeList(null, null, null, '&nbsp;'));
   
    $this->set(compact('formHeading', 'outcomes', 'currentPunditId'));

  }//end admin_add()


  /**
   * admin_edit method
   *
   * @param string $id call edit
   * @return void
   */
  public function admin_edit($id = null) {  
    if (!$this->isMobile) {
      $this->layout = 'iframe';
    } else {
      if (!$this->Session->check('refLocation')) {     
        $url = '/';      
        if (strpos($this->referer(), 'admin/suggested_pundits') !== false || strpos($this->referer(), 'admin/calls') !== false) {
          $url = array('controller' => 'calls', 'action' => 'index', 'admin' => true);
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
    $this->Call->id = $id;
    if (!$this->Call->exists()) {
      throw new NotFoundException(__('Invalid Prediction Suggestion'));
    }
    
    if ($this->request->is('ajax')) {     
      $yield = $this->Call->getPunditYield($this->request->data['Call'], $id);
      return $this->sendJson($yield);     
    }
        
    if ($this->request->is('post') || $this->request->is('put')) {           
      //$vote_end_date = $this->Call->voteEndDate($this->request->data); 
      if (!empty($this->request->data['Call']['outcome_id']) && ($this->request->data['Call']['ptvariable'] != null)) {
       
        $yield = $this->Call->getPunditYield($this->request->data['Call'], $id);
        $this->request->data['Call']['yield'] = $yield;
        if ($this->request->data['Call']['is_calculated']) {
          //calculating boldness
          $boldness = $this->Call->getPunditBoldness($this->request->data['Call']['outcome_id'], $this->request->data['Call']['ptvariable'], $id);
          //setting boldness and yield          
          $this->request->data['Call']['boldness'] = $boldness;
        }        
      } else {
        $this->request->data['Call']['yield'] = 0;
      }

      if(!empty($this->request->data['Call']['category_id']) && !empty($this->request->data['Call']['user_id'])) {
        $this->Pundit->punditCategoryAccess($this->request->data['Call']['user_id'], $this->request->data['Call']['category_id']);
      }    

      if ($this->Call->save($this->request->data)) {
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
    } else {
      $this->Call->contain();
      $this->request->data = $this->Call->read(null, $id);
      $punditList = true;
    }
    
    if ($punditList) {
      if (!empty($this->request->data['Call']['category_id'])) {
        $query = "SELECT users.id, 
          CONCAT_WS(' ', users.first_name, users.last_name) AS pundit_name 
          FROM `pundit_categories`, `pundits`, `users` 
          WHERE 
          pundits.id = pundit_categories.pundit_id 
          AND 
          users.id = pundits.user_id 
          AND 
          category_id='".$this->request->data['Call']['category_id']."' 
          ORDER BY  `pundit_name` ASC";

        $pundits = $this->Pundit->query($query);

        foreach($pundits as $pundit) {
          $users[$pundit['users']['id']] = $pundit[0]['pundit_name'];
        }
        $this->set('users', $users);
      } //end if      
    }
  
    $outcomes = $this->Outcome->find('list', array(
      'fields' => array('id', 'title'),
      'conditions' => array('id NOT' => '3'),
      'order' => 'id',
      )
    );
    $predictionId = $id;
    $categories = $this->Call->Category->generateTreeList(null, null, null, '&nbsp;');
    $this->set(compact('categories', 'outcomes', 'predictionId'));
  
  }//end admin_edit()
    
     
  /**
   * method used to approve prediction
   * 
   * @param integer $predictionId 
   *
   * @return void
   */
  public function admin_approve($predictionId = null)
  {

    $response = array();
    $this->autoRender = false;
    $this->layout = false;
    $this->Call->id = $predictionId;   
   
    if ($this->request->is('ajax')) { 
      $this->Call->contain();
      $callData = $this->Call->find(
        'first',
        array(
          'conditions' => array(
            'Call.id' => $predictionId
          )
        )
      );
      
      $response['empty'] = false;
      if (empty($callData['Call']['due_date']) || empty($callData['Call']['vote_end_date'])) {
        $response['success'] = false;
        $response['message'] = 'Please select Vote End Date and Due Date first !!!';
        $response['empty']   = true;
        return $this->sendJson($response);
      }

      $data['approved']      = 1;
      $data['approval_time'] = date('Y-m-d H:i:s');
      $response['success']   = false;
      $response['message']   = 'Prediction not approved';
      if ($this->Call->save($data)) {
        $response['success'] = true;
        $response['message'] = 'Prediction approved';
      }
    }
    return $this->sendJson($response);
  }//end admin_approve()
  
  
  /**
   * method used to display all approved predictions
   *
   * @return void
   */
  /*public function admin_all()
  {
  	$this->paginate = array(
  	  'conditions' => array(
          'approved' => 1,
          'due_date <' => date('Y-m-d H:i:s'),
      ),
      'contain' => array(
        'User'             
      ),
      'order'  => array(
        'due_date' => 'DESC'
      ),
      'limit' => 6
    );
    //all pundits returns
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
    $this->set('calls', $this->paginate('CallDummy'));
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set('outcomes', $outcomes);
  }//end admin_all()*/
  
  
  /**
   * method used to display all history
   *
   * @return void
   */
  public function history($catId = null)
  {
	  $this->paginate = array(
  	  'conditions' => array(         
        'approved' => 1,
        'category_id' => $catId
      ),
      'contain' => array(
        'User',
        'Outcome', 
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          ),
        )             
      ),      
      'limit' => 20,
      'order'  => array(
        'vote_end_date' => 'ASC'
      ),
    );
    //all pundits returns
    $this->Call->bindModel(
      array(
        'belongsTo' => array(
          'User' => array(
            'foreignKey'  => 'user_id',
            'type'        => 'inner',           
          )          
        ),
      ), false
    );   
    //debug($this->paginate('Call'));
    $this->set('calls', $this->paginate('Call'));

    $categoryName = $this->Call->Category->field('name', array('id' => $catId));
    $this->set(compact('categoryName', 'catId'));
  }//end history()


  /**
   * Method used to upload csv file
   * 
   * @return void
   */ 
  public function admin_upload_csv() {

    $validateCall = $failedCall = $invalidError = array();
    if ($this->request->is('post')) {

      $this->Call->set($this->request->data);
      if ($this->Call->validates() == false) {       
        $invalidError = $this->Call->validationErrors;     
        $this->set('invalidError', $invalidError);
      }
  
      if (is_uploaded_file($this->request->data['Call']['csv_file']['tmp_name']) && empty($invalidError)) {
        $punditUserId = $this->request->data['Call']['user_id'];
        $punditId = $this->Call->Pundit->field('id', array('Pundit.user_id' => $punditUserId));

        $categoryId = $this->Pundit->PunditCategory->field('category_id', array(
          'pundit_id' => $punditId));

        $params = array(
          'category_id' => $categoryId,
          'pundit_user_id' => $punditUserId,
          'date_format' => $this->request->data['Call']['date_format'] ? 
          $this->request->data['Call']['date_format'] : 1,
        );

        $this->Pundit->punditCategoryAccess($punditUserId, $categoryId);
      
        $path = $this->request->data['Call']['csv_file']['tmp_name'];
       
        App::import('Vendor', 'parseCSV', array('file' => 'parsecsv.lib.php'));
        $csv          = new parseCSV();
        $csv->heading = false;     
        $csv->auto($path);
        $row       = 1;
        $inserted  = 0;
        $errors    = 0;          
        if (!empty($csv->data)) {
          $totalCalls = count($csv->data) - 1;         
          foreach ($csv->data as $data) {           
            set_time_limit(30);
            if ($row > 1) {                    
          
              $data = $this->Call->__getDataFromCSV($data, $params);
              $this->Call->create();         
              if ($this->Call->save($data)) {
                //echo "Row number #$row inserted<br/>";            
                $inserted++;
              } else {            
                $error = $this->Call->validationErrors;
        
                $failedCall[$row] = array(
                  'prediction' => $data['prediction'],
                  'error' => $error
                );           
                $errors++;                  
              } 
            }           
            $row++;            
          }//end foreach

          if ($totalCalls == $inserted) {
            $this->setFlash(__("Successfully uploaded $inserted calls"));   
          } else {            
            $this->setFlash(__("Total $totalCalls calls uploaded but $errors calls could not inserted", 'error'));  
          }        
        }// csv data
      
      } //end is uploaded if

    }// end post if

    $this->set('validateCall', $failedCall);

    $query = "SELECT users.id, 
      CONCAT_WS(' ', users.first_name, users.last_name) AS pundit_name 
      FROM `pundit_categories`, `pundits`, `users` 
      WHERE 
      pundits.id = pundit_categories.pundit_id 
      AND 
      users.id = pundits.user_id           
      ORDER BY  `pundit_name` ASC";

    $pundits = $this->Pundit->query($query);

    foreach($pundits as $pundit) {
      $users[$pundit['users']['id']] = $pundit[0]['pundit_name'];
    }   
    $this->set(compact('users'));
   
  }// End upload_csv();
   

  /**
   * Method used to search prediction or pundit with matching keyword
   * 
   * @return void
   */ 
  function search() {
   
    if (isset($this->request->data['Call']['keyword'])) {    
      if (strlen($this->request->data['Call']['keyword']) < 3) {
        $this->set('invalid', true);
        return;
      }
      $this->Session->write('findRaw', $this->request->data['Call']['keyword']);
    }
    
    $searchKeyword = $this->Session->read('findRaw');
    $findRaw = !empty($searchKeyword) ? $searchKeyword : null;

    $userId = ($this->Auth->user('id') ? $this->Auth->user('id') : 0); 

    if (!empty($findRaw)) {
  
      $option = array(
        'fields' => array(
          "CONCAT_WS(' ', User.first_name, User.last_name) AS pundit_name",          
          'User.id',
          'User.first_name',
          'User.last_name'
        ),
        'group' => 'User.id HAVING pundit_name LIKE '."'%".$findRaw."%'",     
        'order' => 'pundit_name',
        'contain' => array(
          'Pundit.score', 
          'Pundit.calls_graded'
        ) 
      );
      $this->Pundit->User->bindModel(
        array(
          'hasOne' => array(
            'Pundit' => array(
              'foreignKey' => 'user_id', 
              'type' => 'inner', 
              'conditions' => array(),
            ),
          ),
        )        
      );    
      $userData = $this->Pundit->User->find('all', $option);   
      $totalPunditFound = count($userData);
     // debug($userData);
      $this->set(compact('userData', 'totalPunditFound')); 

      $this->paginate = array(
        'conditions' => array(
          'Call.prediction LIKE' => "%$findRaw%",
          'Call.approved' => 1        
        ),
        'contain' => array(
          'User',
          'Vote' => array(
            'conditions' => array(
              'Vote.user_id' => array($userId, NULL),
            )
          ),       
        ),     
        'limit' => 20, 
      );
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
      $this->set('calls', $this->paginate()); 
    }
    $this->set(compact('findRaw'));
   
  }//end search()  


  /**
   * Method to create slug
   * 
   * @return void
   */
  function admin_slug() {
    set_time_limit(0);
    $this->autoRender = false;
    $calls = $this->Call->find('all', array('fields' => array('id', 'prediction')));
    foreach ($calls as $call) {    
      $this->Call->id = $call['Call']['id'];
      $this->Call->save($call);
    }
    print("DONE");

  }//end admin_slug

  /**
   * Method to change user to pundit
   * 
   * @return void
   */
  public function create_pundit() {
    $user_id = $this->Auth->user('id');
    if (!empty ($user_id)) {
      $user_info = $this->Call->User->find('first', 
        array(
          'fields' => 
          array(
            'id', 'score', 'avg_boldness', 'calls_graded', 'calls_correct' 
          ),
          'conditions' =>
          array(
            'id' => $this->Auth->user('id')
          )
        )
      );
      $data = $user_info['User'];
      $data['user_id'] = $user_info['User']['id'];
      unset($data['id']);
      $this->Call->Pundit->save($data);
      $test = ClassRegistry::init('aros')->find('first', 
        array(
          'fields' => 
          array(
            'id', 'parent_id' 
          ),
          'conditions' =>
          array(
            'foreign_key' => $data['user_id']
          )
        )
      );
      $aros_data = $test;
     
      $aros_data['aros']['parent_id'] = 3;
     ClassRegistry::init('aros')->save($aros_data['aros']);
    }
  
  }// end create_pundit

  	
}//end class
