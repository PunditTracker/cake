<?php
/**
 * File used as category model
 *
 * Contains code needed mainly for categories controller
 *
 * @category Model
 */

/**
 * category model class
 *
 * @category Model
 */
class Category extends AppModel
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = "Category";


  /**
   * Property is used to hold the behaviours.
   *
   * @var array contains the behaviour list
   *
   * @since 1.0.0
   */
  public $actsAs = array(
    'Tree',
    'Containable',
    'Sluggable' => array(
      'label'     => 'name',
      'slug'      => 'slug',
      'separator' => '-',
      'overwrite' => true
    )
  );


  /**
   * Property used to store validation rules for category model's fields.
   *
   * @var array Validation rules for model's fields
   * @since 1.0.0 Apr 18, 2008
   *
   * @access public
   */
  public $validate = array(
    'name' => array(
      'required' => array(
        'rule' => array('notempty'),
      ),
    ),
    'rating' => array(
      'required' => array(
        'rule' => array('notempty'),
      ),
    ),
    'category_id' => array(
      'required' => array(
        'rule' => array('notempty'),
      ),
    ),
  );


  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array('Call');


  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array(
    'Pundit' => array(
      'joinTable'             => 'pundit_categories',
      'foreignKey'            => 'category_id',
      'associationForeignKey' => 'pundit_id'
    )
  );


  /**
   * method used to return top pundits
   *
   * @param string $categoryId category id
   * @param string $limit limit
   * @param string $categoryLimit category limit
   *
   * @return array
   */
  public function getTopPundit($categoryId = null, $limit = 5, $categoryLimit = 5)
  {
    $option = array(
      'contain' => array(
        'Pundit' => array(
          'conditions' => array('Pundit.featured' => 1),
          'limit' => $limit,
          'order' => 'Pundit.score DESC',
          'User'
        )
      ),
      'limit' => $categoryLimit
    );

    if (!empty($categoryId)) {
      $option['conditions'] = array(
        'Category.id' => $categoryId,
      );
      $topPundit = $this->find('first', $option);
    } else {

      /*$option = array(
        'contain' => array('Category', 'Pundit' => 'User'),
        'group' => 'category_id'
      );
      ClassRegistry::init('pundit_categories')->bindModel(
        array(
          'belongsTo' => array(
            'Category' => array(
              'limit' => $limit
            ),
            'Pundit' => array(
              //'conditions' => array('Pundit.featured' => 1),
              'order' => 'score DESC'
            ),
          ),
        ), false
      );
      $topPundit = ClassRegistry::init('pundit_categories')->find('all', $option); */
      $option = array(
        'conditions' => array('Pundit.featured' => 1),
        'limit' => $limit,
        'order' => 'rand()',
        'contain' => array(
          'User', 'Category'
        ),
      );

      $topPundit = $this->Pundit->find('all', $option);
    }

    return $topPundit;
  }//end getTopPundit()


  /**
   * method used to return category related pundits
   *
   * @param integer $categoryId category id
   *
   * @return array
   */
  public function getPunditCategoryData($categoryId = null)
  {
    $options = array(
        'contain' => 'Pundit',
        'conditions' => array('id' => $categoryId)
      );
    if ($categoryId == 'all') {
      unset($options['conditions']);
    }
    $categoriesWithPundits = $this->Pundit->Category->find(
      'all',
      $options
    );
    foreach ($categoriesWithPundits as $key => $categoryWithPundits) {
      $userIds = array_unique(Set::extract('/user_id', $categoryWithPundits['Pundit']));
      unset($categoriesWithPundits[$key]['Pundit']);
      $this->Pundit->User->bindModel(array('hasOne' => array('Pundit')));
      $params = array(
        'conditions' => array('User.id' => $userIds),
        'contain' => array('Pundit.score', 'Pundit.calls_graded'),
        'fields' => array(
          'User.id',
          'User.first_name',
          'User.last_name',
          'User.slug'
        ),
        'order' => array('User.last_name' => 'asc')
      );
      $categoriesWithPundits[$key]['User'] = $this->Pundit->User->find('all', $params);
    }
    return($categoriesWithPundits);
  }//end getPunditCategoryData()


  /**
   * Method to get all categories for building sitemap
   *
   * @return array Array for building the sitemap
   */
  public function getCategoriesForSitemap() {

    $categories = $this->find('all', array('contain' => false));

    $return = array();

    foreach ($categories as $category) {
      $return[] = array(
        'loc' => Router::url(array(
          'controller' => 'categories',
          'action' => 'view',
          $category['Category']['slug']
        ), true),
      );
    }

    return $return;
  }//end getCategoriesForSitemap()


}//end class
