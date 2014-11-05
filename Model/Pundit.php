<?php
/**
 * File used as Pundit model
 *
 * Contains code needed mainly for Pundit controller
 *
 * @category Model
 */

/**
 * Pundit model class
 *
 * @category Model
 */
class Pundit extends AppModel
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = 'Pundit'; 


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
    )    
  );


   /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array( 
    'Category' => array(       
      'joinTable'             => 'pundit_categories', 
      'foreignKey'            => 'pundit_id', 
      'associationForeignKey' => 'category_id',
      'dependent'             => true
    )
  );



  /**
   * method used to return pundits whose last name between A to H
   * 
   * @param string $userId user id
   * @param string $categoryId category id
   *
   * @return array
   */
  function punditCategoryAccess($userId = null, $categoryId = null) {

    $punditId = $this->field('id', array('user_id' => $userId));
    $option = array(
      'conditions' => array(
        'pundit_id' => $punditId, 
        'category_id' => $categoryId
      )
    );
    if ($this->PunditCategory->find('first', $option)) {
      return true;
    } else {
      throw new MethodNotAllowedException();
      return false;
    }
  }


  /**
   * Method to get all pundits for building sitemap
   *
   * @return array Array for building the sitemap
   */
  public function getPunditsForSitemap() {
    $options = array(
      'contain' => array('User.slug'),
      'fields' => array('Pundit.id'),
      'order' => 'Pundit.calls_graded DESC',
    );

    $pundits = $this->find('all', $options);

    $return = array();

    foreach ($pundits as $pundit) {
      $return[] = array(
        'loc' => Router::url(array(
          'controller' => 'pundits',
          'action' => 'profile',
          $pundit['User']['slug']
        ), true),
      );
    }

    return $return;
  }//end getPunditsForSitemap()

   /**
   * Method to get pundits best predictions
   *
   * @return array for shop best prediction
   */
  public function bestWorstPredictions($userId = null) { 
    // get's top 3 best calls
    $best = $this->User->Call->find('all',
                  array(
                    'fields' => 
                    array(
                      'Call.prediction', 'Call.created'
                    ),
                    'order' => 'Call.yield DESC',
                    'conditions' =>
                    array(
                      'Call.user_id' => $userId,
                      'outcome_id' => array(5, 4),
                      'approved' => 1,
                      'Call.yield NOT' => 0
                    ),
                    'contain' => false,
                    'limit'   => 3
                  )
                );
    // get's top 3 worst calls
    $worst = $this->User->Call->find('all',
                  array(
                    'fields' => 
                    array(
                      'Call.prediction', 'Call.created'
                    ),
                    'order' => 'Call.yield asc, Call.boldness DESC',
                    'conditions' =>
                    array(
                      'Call.user_id' => $userId,
                      'approved' => 1,
                      'outcome_id' => array(1, 2),
                    ),
                    'contain' => false,
                    'limit'   => 3
                  )
                );
    $result['best'] = $best;
    $result['worst'] = $worst;
    return $result;
  }
    
}//end class
