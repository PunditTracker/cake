<?php
/**
 * File used as SuggestedPundit model
 *
 * Contains code needed mainly for SuggestedPundit controller
 *
 * @category Model
 */

/**
 * SuggestedPundit model class
 *
 * @category Model
 */
class SuggestedPundit extends AppModel 
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $displayField = 'name';


  /**
   * Validation rules
   *
   * @var array
   */
  public $validate = array(
    'pundit_name' => array(
      'notempty' => array(
          'rule' => array('notempty'),                
      ),
    ),
    'category_id' => array(
      'notempty' => array(
          'rule' => array('notempty'),                
      ),
    ),
  );


  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(  
    'User' => array(
      'className'  => 'User',
      'foreignKey' => 'user_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
    'Category' => array(
      'className'  => 'Category',
      'foreignKey' => 'category_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    )
  );

   
  /**
   * method used to approve suggested pundit
   * 
   * @param integer $suggestedPunditId 
   * 
   * @return
   */
  public function approveSuggestedPundit($suggestedPunditId = null)
  { 
	  $this->id = $suggestedPunditId;
    $data['SuggestedPundit']['approve'] = 1;
    $data['SuggestedPundit']['approval_time'] = date('Y-m-d H:i:s');
    $flag = false;
    if ($this->save($data)) {     
	    $this->contain('Category.id');
      $punditData = $this->find(
        'first', 
        array(
          'conditions' => array(
            'SuggestedPundit.id' => $suggestedPunditId
          )
        )
      );
      $this->User->create();
      $punditName = explode(" ", $punditData['SuggestedPundit']['pundit_name'], 2);     
      if (isset($punditName[0])) {
  	    $newUser['User']['first_name'] = $punditName[0];
      }
      if (isset($punditName[1])) {
        $newUser['User']['last_name'] = $punditName[1];
      }     
  	  $newUser['User']['password'] = randomChars(8);

  	  if ($this->User->save($newUser)) {
        $userId['Pundit']['user_id'] = $this->User->id;
        $parentGroupId = Configure::read('pundit_group_id');     
        $this->User->setUserGroup($userId['Pundit']['user_id'], $parentGroupId); 
        if (ClassRegistry::init('Pundit')->save($userId)) {
          $pundit['PunditCategory']['pundit_id'] = ClassRegistry::init('Pundit')->id;
          $pundit['PunditCategory']['category_id'] = $punditData['Category']['id'];
          if (ClassRegistry::init('PunditCategory')->save($pundit)) {
            
          }
        }
  	  }
      $flag = true;
    }     
    return $flag;
    
  }//end approveSuggestedPundit()
  
  
  /**
   * method used to create/edit and approve suggested pundit
   * 
   * @param integer $data 
   * 
   * @return bool
   */
  public function saveAndApprovePundit($data = null) {   

    unset($this->User->validate['email']);   
    $flag = false;
    $this->User->create(); 
    if (empty($data['Category']['category_id'])) {
      $this->invalidate('category_id', 'required');  
    }
    if ($this->User->save($data)) {
      $flag = true; 
      $punditRecord['Pundit']['user_id'] = $this->User->id;
      $punditRecord['Pundit']['featured'] = $data['Pundit']['featured'];        
      $parentGroupId = Configure::read('pundit_group_id');     
      $this->User->setUserGroup($punditRecord['Pundit']['user_id'], $parentGroupId); 
      
      if (ClassRegistry::init('Pundit')->save($punditRecord)) {
        $flag = true; 
        $punditCat['PunditCategory']['pundit_id'] = ClassRegistry::init('Pundit')->id;
        $punditCat['PunditCategory']['category_id'] = $data['Category']['category_id'];
        
        if (ClassRegistry::init('PunditCategory')->save($punditCat)) {
          $flag = true;       
        } 
      } 
      
      if (!empty($data['SuggestedPundit']['id'])) {
        $SuggestedPunditData['SuggestedPundit']['id'] = $data['SuggestedPundit']['id'];
        $SuggestedPunditData['SuggestedPundit']['approve'] = 1;
        $SuggestedPunditData['SuggestedPundit']['approval_time'] = date('Y-m-d H:i:s');
       
        ClassRegistry::init('SuggestedPundit')->save($SuggestedPunditData);
      }
    } 
    return $flag;
  }//end saveAndApprovePundit()


}//end class
