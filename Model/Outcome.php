<?php
/**
 * File used as Outcome model
 *
 * Contains code needed mainly for Outcome controller
 *
 * @category Model
 */

/**
 * Outcome model class
 *
 * @category Model
 */
class Outcome extends AppModel
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = 'Outcome';
  
  
  /**
   * Property used to store validation rules for model's fields.
   *
   * @var array Validation rules for model's fields
   * @since 1.0.0 Apr 18, 2008
   *
   * @access public
   */
  public $validate = array(
    'title' => array(
      'required' => array(
        'rule'    => array('notempty')
      ),
    ),
    'rating' => array(
      'required' => array(
        'rule'    => array('notempty')
      ),
    ),
  );
  
  
}//end class
