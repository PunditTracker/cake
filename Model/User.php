<?php
/**
 * File used as User model
 *
 * Contains code needed mainly for users model
 *
 * @category Model
 */

/**
 * User model class
 *
 * @category Model
 */
class User extends AppModel
{

  /**
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = 'User';


  /**
   * array to hold behavior.
   *
   * @return void
   */
  public $actsAs = array(
    'Containable',
    'Upload',
    'Sluggable' => array(
      'label'     => array('first_name', 'last_name'),
      'slug'      => 'slug',
      'separator' => '-',
      'overwrite' => true
    )
  );


  /**
   * Property used to store belongs to relations for model.
   *
   * @var array belongs to relations for model
   */
  public $belongsTo = array();


  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  public $hasAndBelongsToMany = array();


  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'Call' => array(
      'className'     => 'Call',
      'foreignKey'    => 'suggested_by_user_id',
      'conditions'    => '',
      'order'         => '',
      //'limit'         => '5',
      'dependent'     => false
    ),
    'Vote' => array(
      'className'     => 'Vote',
      'foreignKey'    => 'user_id',
      'conditions'    => '',
      'order'         => '',
      //'limit'         => '5',
      'dependent'     => true,
    ),
    'SuggestedCall',
  );


  /**
   * Property used to store validation rules for model's fields.
   *
   * @var array Validation rules for model's fields
   * @since 1.0.0 Apr 18, 2008
   *
   * @access public
   */
  public $validate = array(
    'first_name' => array(
      'notempty' => array(
        'rule'    => array('notempty'),
        'message' => 'Please enter first name',
      ),
    ),
    'password' => array(
      'required' => array(
        'rule'    => array('notempty'),
        'message' => 'Password can not be empty',
      ),
    ),
    'old_password' => array(
      'required' => array(
        'rule' => array('notempty'),
        'message' => 'Please Enter old password.',
      ),
      'confirm' => array(
        'rule'    => array('oldPassword'),
        'message' => 'Please enter correct existing password.',
      ),
    ),
    'password2' => array(
      'required' => array(
        'rule' => array('notempty'),
        'message' => 'Please confirm your password',
      ),
      'confirm' => array(
        'rule'    => array('confirmPassword'),
        'message' => 'Password could not match',
      ),
    ),
    'last_name' => array(
      'notempty' => array(
        'rule' => array('notempty'),
        'message' => 'Please enter last name',
      ),
    ),
    'email' => array(
      'notempty' => array(
        'rule' => array('notempty'),
        'message' => 'Please enter email address',
      ),
      'email' => array(
        'rule' => array('email'),
        'message' => 'Please enter valid email address',
      ),
      'unique' => array(
        'rule' => array('isUnique'),
        'message' => 'Email already exist',
      ),
    ),
    'category_id' => array(
      'notempty' => array(
          'rule' => array('notempty'),
      ),
    ),
  );


  /**
   * Method used to beforeValidate in user sign-up
   *
   * @param array $options Options passed from model::save(), see $options of model::save().
   *
   * @return void
   */
  function beforeValidate($options = array())
  {

    return true;
  }//end beforeValidate()


  /**
   * callback function
   *
   * @param array $options
   *
   * @return void.
   */
  public function beforeSave($options = array()) {
    if(isset($this->data['User']['password'])) {
      $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
    }
    return true;
  }


  /**
   * Method used to check for password confirmation
   *
   * @return boolean If password is not match with confirm_password then return false otherwise return true
   */
  public function confirmPassword()
  {
    // Check password and confirm_password are same or not
    return ($this->data['User']['password'] == $this->data['User']['password2']);
  }//end confirmPassword()


  /**
   * Method used to check old password
   *
   * @return boolean If old password exist
   */
  public function oldPassword()
  {
    $oldPwd = $this->field('password', array('id' => $this->id));
    // Check old password
    return (Security::hash($this->data['User']['old_password'], null, true) == $oldPwd);
  }//end confirmPassword()



  /**
   * Callback function to handle logic after save operation.
   *
   * @param boolean $created True if this save created a new record
   *
   * @access public
   *
   * @return void
   */
  public function afterSave($created)
  {
    // Call to function to save user group.
    $userId = $this->id;
    if (!empty($this->data['User']['group_id'])) {
      $parentGroupId = $this->data['User']['group_id'];
    }
    if (!empty($userId) && !empty($parentGroupId)) {
      $this->setUserGroup($userId, $parentGroupId);
    }
  }//end afterSave()


  /**
   * Function to set user group.
   *
   * @param integer $userId        User id.
   * @param integer $parentGroupId Group id.
   *
   * @return void
   */
  public function setUserGroup($userId, $parentGroupId)
  {
    $aro = ClassRegistry::init('Aro');
    // Condition to delete existing record from aros
    $conditions = array('Aro.foreign_key' => $userId);
    // Delete the member from aros table
    $aro->deleteAll($conditions);

    // Build data to save
    $data = array(
      'parent_id'   => $parentGroupId,
      'foreign_key' => $userId,
      'alias'       => 'User::' . $userId,
    );

    // Prepare model to save data
    $aro->create();
    // Save needed data
    $aro->save($data);

  }//end setUserGroup()


  /**
   * Function to get all the user groups
   *
   * @access public
   *
   * @return array $userGroups User groups.
   */
  /*public function getUserGroups()
  {
    $aro        = ClassRegistry::init('Aro');
    $options    = array(
      'conditions' => array(
        'Aro.foreign_key' => NULL,
        'Aro.id <>' => Configure::read('anonymous_user_id')
      ),
      'fields'     => array(
        'id',
        'alias',
      ),
    );
    $userGroups = $aro->find('list', $options);
    unset($userGroups['2']);
    return $userGroups;
  }//end getUserGroups()*/


  /**
   * This method updates username and user website from facebook data
   *
   * @param array $userData Auth data
   *
   * @return void
   */
  public function updateUsername($userData)
  {
    $randNum = rand(0, 100);
    if ( $randNum >= 50 ) {
      $this->id = $userData['id'];
      $this->save(
        array(
         'User.first_name' => $userData['first_name'],
         'User.last_name' => $userData['last_name'],
        ),
        false
      );
    }
  }//end updateUsername()


  /**
   * Function to check valid user
   *
   * @param integer $userId User id.
   *
   * @return void
   */
  public function validUser($uId = null, $group = null, $admin = false)
  {
    $option = array('conditions' => array('User.id' => $uId));
    if (!$admin) {
      $option['contain'] = 'Aro';
      $this->bindModel(
        array(
          'hasOne' => array(
            'Aro' => array(
              'foreignKey' => 'foreign_key',
              'type' => 'inner',
              'conditions' => array(
               'Aro.parent_id' => $group
              ),
            ),
          ),
        ), false
      );
    }
    $result = $this->find('first', $option);

    if (false === $result) {
      return false;
    }
    return true;

  }//end validUser()


  /**
   * Function to check valid slug
   *
   * @param string $userSlug       user slug.
   * @param string $predictionSlug prediction slug.
   *
   * @return void
   */
  function __checkValidSlug($userSlug = null, $predictionSlug = null) {

    $return = array();
    $return['success'] = true;
    $return['prediction'] = false;

    if (!empty($userSlug)) {

      if (!empty($predictionSlug)) {
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
        $this->Call->contain(array(
          'Outcome',
          'Vote' => array(
            'conditions' => array('user_id' => $this->field('id', array('slug' => $userSlug)))
          ),
          'User'
          )
        );
        $callBySlug = $this->Call->findBySlug($predictionSlug);
        if ($callBySlug == false) {
          $return['success'] = false;
          $return['location'] = array('action' => 'profile');
        } else {
          $return['prediction'] = true;
          $return['data'] = $callBySlug;
        }
      }

      $slugById = $this->field('slug', array('id' => $userSlug));
      if ($slugById !== false) {
        $return['success'] = false;
        $return['location'] = array('action' => 'profile', $slugById);
      }

      if ($return['success']) {
        $this->contain();
        //$users = $this->findBySlug($userSlug);
        $users = $this->find('first', array('conditions' => array('slug' => $userSlug, 'private' => 0)));
        if ($users == false) {
          $return['success'] = false;
          $return['location'] = array('action' => 'profile');
        } else {
          $return['User'] = $users['User'];
        }
      }

    }
    return $return;

  }//end __checkValidSlug()


  /**
   * Method to get all users for building sitemap
   *
   * @return array Array for building the sitemap
   */
  public function getUsersForSitemap() {
    $options = array(
      'contain' => false,
      'fields' => array('User.slug'),
      'order' => 'User.id ASC',
    );

    $users = $this->find('all', $options);

    $return = array();

    foreach ($users as $user) {
      $return[] = array(
        'loc' => Router::url(array(
          'controller' => 'users',
          'action' => 'profile',
          $user['User']['slug']
        ), true),
      );
    }

    return $return;
  }//end getUsersForSitemap()


}//end class
