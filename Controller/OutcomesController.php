<?php
/**
 * File used as Outcomes controller
 *
 * This controller is mainly for Outcomes.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * Outcomes controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class OutcomesController extends AppController 
{
  
  /**
   * Method is used to retrieve all Outcome data
   *
   * @return void
   */
  public function admin_index() 
  {
    //getting list of all categories
    $allOutcomes = $this->Outcome->find('all');
    $this->set('allOutcomes', $allOutcomes);
  }//end admin_index()
  
  
  /**
   * method to add new Outcome
   *
   * @return void
   */
  public function admin_add()
  {
    if ($this->request->is('post') || $this->request->is('put')) {
      $total = $this->Outcome->find('count');
      if ($total >= 5) {
        $this->setFlash(__('All 5 Outcome has been created already'), 'success');
        $this->redirect(array('action' => 'index'));
      }
      $this->Outcome->create();
      //saving new category
      if ($this->Outcome->save($this->request->data)) {
        //show flash message
        $this->setFlash(__('The outcome has been saved'), 'success');
        //redirect page
        $this->redirect(array('action' => 'index'));
      } else {
          return $this->setFlash('The outcome could not be saved. Please, try again.');
      }
    }
  }//end admin_add()
  
  
  /**
   * Method is used for editing Outcome
   *
   * @param integer $id Outcome id
   *
   * @return void
   */
  public function admin_edit($id = null)
  {
    //set category id
    $this->Outcome->id = $id;
    //if the selected category does not exist
    if (!$this->Outcome->exists()) {
      throw new NotFoundException(__('Invalid Outcome'));
    }
    //check whether request is post or not
    if ($this->request->is('post') || $this->request->is('put')) {
      //updating category information
      if ($this->Outcome->save($this->request->data)) {
        //show flash message
        $this->setFlash(__('The Outcome has been updated'), 'success');
        $this->redirect(array('action' => 'index'));
      } else {
        //show flash message
        $this->setFlash(__('The Outcome could not updated. Please, try again.'), 'error');
      }
    } else {
      $this->request->data = $this->Outcome->read(null, $id);
    }
  }//end admin_edit()
  
  
  /**
   * Method is used to delete Outcome
   *
   * @param integer $id Outcome id
   *
   * @return void
   */
  public function admin_delete($id = null)
  {
    $this->Outcome->id = $id;
    //check if the selected category does not exist
    if (!$this->Outcome->exists()) {
      //throw exception
      throw new NotFoundException(__('Invalid Outcome'));
    }
    //deleting selected category
    if ($this->Outcome->delete()) {
      //show flash message
      $this->setFlash(__('Outcome deleted'), 'success');
      //redirect page
      $this->redirect(array('action' => 'index'));
    } else {
      $this->setFlash(__('Outcome was not deleted'), 'error');
    }
  }//end admin_delete()
  
  
}//end class
