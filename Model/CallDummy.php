<?php
/**
 * File used as CallDummy model
 *
 * Contains code needed mainly for CallDummy model
 *
 * @category Model
 */

/**
 * CallDummy model class
 *
 * @category Model
 */
class CallDummy extends AppModel
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */ 
  public $name = 'CallDummy';


  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $useTable = 'calls';
  
  
  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(  
    'User' => array(
      'className'  => 'User',
      'foreignKey' => 'suggested_by_user_id',
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
    ),
    'Pundit' => array(
      'className'  => 'Pundit',
      'foreignKey' => 'user_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
    'Outcome' => array(
      'className'  => 'Outcome',
      'foreignKey' => 'outcome_id',
      'conditions' => '',
      'fields'     => '',
      'order'      => ''
    ),
  );   
  
  
  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array('Vote');

    
}//end class
