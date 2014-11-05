<?php
/**
 * File used as Categories controller
 *
 * This controller is mainly for Categories.
 *
 * PHP version 5
 *
 * @category Controller
 * @package  PunditTracker
 */

/**
 * Categories controller class
 *
 * @category Controller
 * @package  PunditTracker
 *
 */
class CategoriesController extends AppController
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
   * Property is used to hold the string.
   *
   * @var string to be implemented
   *
   * @since 1.0.0
   */
  public $name = "Categories";


  /**
   * different models used
   *
   * @array contains models
   */
  public $uses = array('Category', 'User', 'Call', 'CallDummy', 'Pundit', 'Vote', 'Outcome');


  /**
   * Method is used to retrieve all category data
   *
   * @return void
   */
  public function admin_index()
  {
    //getting list of all categories
    $allCategories = $this->Category->generateTreeList();
    $this->set('allCategories', $allCategories);
    $categoriesList = $this->Category->find(
      'list',
      array(
        'fields' => array('id', 'featured')
      )
    );
    $this->set('categoriesList', $categoriesList);
  }//end admin_index()


  /**
   * method to add new category
   *
   * @return void
   */
  public function admin_add()
  {
    //getting list of all categories
    $parents = $this->Category->generateTreeList(null, null, null, '&nbsp;');
    $this->set(compact('parents'));
    //check whether request is post or not
    if ($this->request->is('post') || $this->request->is('put')) {

      $this->Category->create();
      //setting the parent id if no parent selected
      if (empty($this->request->data['Category']['parent_id'])) {
        $this->request->data['Category']['parent_id'] = 0;
      }
      //saving new category
      if ($this->Category->save($this->request->data)) {
        //show flash message
        $this->setFlash(__('The category has been saved'), 'success');
        //redirect page
        $this->redirect(array('action' => 'index'));
      } else {
        $this->setFlash('The category could not be saved. Please, try again.');
      }
    }
  }//end admin_add()


  /**
   * Method is used for editing category
   *
   * @param integer $id category id
   *
   * @return void
   */
  public function admin_edit($id = null)
  {
    //set category id
    $this->Category->id = $id;
    //if the selected category does not exist
    if (!$this->Category->exists()) {
      throw new NotFoundException(__('Invalid Category'));
    }
    //check whether request is post or not
    if ($this->request->is('post') || $this->request->is('put')) {

      $this->request->data['Category']['slug'] = strtolower(Inflector::slug($this->request->data['Category']['name']));
      //updating category information
      if ($this->Category->save($this->request->data)) {
        //show flash message
        $this->setFlash(__('The category has been updated'), 'success');
        $this->redirect(array('action' => 'index'));
      } else {
        //show flash message
        $this->setFlash(__('The category could not updated. Please, try again.'), 'error');
      }
    } else {
      $this->request->data = $this->Category->read(null, $id);
    }
    //getting the category list
    $parents = $this->Category->generateTreeList(null, null, null, '&nbsp;');
    $this->set(compact('parents'));
  }//end admin_edit()


  /**
   * Method is used to delete categories
   *
   * @param integer $catId category id
   *
   * @return void
   */
  public function admin_delete($catId = null)
  {
    $this->Category->id = $catId;
    //check if the selected category does not exist
    if (!$this->Category->exists()) {
      //throw exception
      throw new NotFoundException(__('Invalid category'));
    }
    //deleting selected category
    if ($this->Category->delete()) {
      //show flash message
      $this->setFlash(__('Category deleted'), 'success');
      //redirect page
      $this->redirect(array('action' => 'index'));
    } else {
      $this->setFlash(__('Category was not deleted'), 'error');
    }
  }//end admin_delete()


  /**
   * Method is used to view all category related calls without pagination
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function view($slug = null)
  {
    if ($slug == 'all') {
      $this->setAction('all_call', 'all');
      return;
    }
    $slugById = $this->Category->field('slug', array('id' => $slug));
    if ($slugById !== false) {
      $this->redirect(array('action' => 'view', $slugById), 301);
    }
    $category = $this->Category->findBySlug($slug);

    $categoryId = $category['Category']['id'];

    $this->Category->id = $categoryId;

    if (!$this->Category->exists()) {
      throw new NotFoundException(__('Invalid Category'));
    }
    $this->Session->delete('refLocation');
    if (!empty($this->params->params['named']['archive'])) {
      $this->setAction('live_archive_call', $categoryId);
    } else {
      $this->setAction('live_archive_call', $categoryId);
    }
  }//end view()

  /**
   * Method is used to view all category related calls archive and live with pagination
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function view_all_calls($slug = null)
  {
    if ($slug == 'all') {
      $this->setAction('all_call', 'all');
      return;
    }
    $slugById = $this->Category->field('slug', array('id' => $slug));
    if ($slugById !== false) {
      $this->redirect(array('action' => 'view', $slugById), 301);
    }
    $category = $this->Category->findBySlug($slug);

    $categoryId = $category['Category']['id'];

    $this->Category->id = $categoryId;

    if (!$this->Category->exists()) {
      throw new NotFoundException(__('Invalid Category'));
    }
    $this->Session->delete('refLocation');
    if (!empty($this->params->params['named']['archive'])) {
      $this->setAction('archive_call', $categoryId);
    } else {
      $this->setAction('live_call', $categoryId);
    }
  }//end view()

  /**
   * Method is used to view all category related live calls
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function live_call($categoryId = null)
  {

    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $allCategoriesData = $this->Category->getPunditCategoryData($categoryId);
    $this->set('allCategoriesData', $allCategoriesData);

    $selectedTab = 'liveCalls';

    $topPundit = $this->Category->getTopPundit($categoryId, 3);

    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('selectedTab', 'categoryId', 'topPundit', 'topUser', 'outcomeData', 'outcomes'));

    $userId = ($this->Auth->user('id') ? $this->Auth->user('id') : 0);

    // Find the children of this category, if any
    $subCategories = $this->Category->children($categoryId);
    $catIds = array();
    if (!empty($subCategories)) {
      $catIds = Set::extract("{n}.Category.id", $subCategories);
    }
    $catIds[] = $categoryId;

    $options = array(
      'conditions' => array(
        'Call.category_id' => $catIds,
        'approved' => 1,
        'OR' => array(
         // 'vote_end_date >=' => date('Y-m-d H:i:s'),
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
      ),
      'contain' => array(
        'User',
        'Vote' => array(
          'conditions' => array(
            'Vote.user_id' => array($userId, NULL),
          ),
          //'order' => 'FIELD(Vote.user_id, "", '.$userId.') ASC',
        ),
        'Category'
      ),
      'fields' => array(
        '*',
        '(CASE
          WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()
            THEN 1              /***** Have not voted yet, but able to vote *******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date > NOW()
            THEN 2              /***** Have voted and able not change ******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date < NOW()
            THEN 3              /***** Have voted and not able to change******/
          ELSE 4                /***** Not able to vote on *******/
        END) AS priority',
      ),
      'limit' => 20,
    );

    /*$options['order'] = 'CASE WHEN Vote.user_id IS NULL
      AND Call.vote_end_date > NOW()
      THEN 0 WHEN Vote.user_id IS NOT NULL
      THEN 1 ELSE 2
      END, Call.vote_end_date DESC, Call.created DESC';*/
    /*$options['order'] = 'CASE
      WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()  /***** Have not voted yet, but able to vote *******
        THEN Call.vote_end_date ASC
      WHEN Vote.user_id IS NOT NULL                             /***** Have voted ******
        THEN Call.vote_end_date ASC
      WHEN Call.vote_end_date <= NOW()                          /***** Not able to vote on *******
        THEN Call.created DESC
      END';*/
    $options['order'] = 'priority ASC,
    CASE WHEN priority != 4
      THEN Call.vote_end_date
    END ASC,
    CASE WHEN priority = 4
      THEN Call.created
    END DESC';

    $this->paginate = $options;
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

    $canonicalUrl = array(
      'action' => 'view',
      $topPundit['Category']['slug'],
    );
    if(($topPundit['Category']['name']) == "SPORTS") {
      $title_for_layouts = "{$topPundit['Category']['name']} Picks &amp; Predictions";
    } elseif (($topPundit['Category']['id']) == 16) {
        $title_for_layouts = "NCAA College Football: Picks &amp; Predictions";
    } elseif (($topPundit['Category']['id']) == 12) {
        $title_for_layouts = "NCAA College Basketball & March Madness: Picks &amp; Predictions";
    } elseif (($topPundit['Category']['parent_id']) == 3) {
        $title_for_layouts = "{$topPundit['Category']['name']} Picks &amp; Predictions";
    } else {
        $title_for_layouts = "{$topPundit['Category']['name']} Predictions &amp; Picks";
    }
    $this->set(compact('subCategories', 'canonicalUrl'));
    $this->set('liveCallData', $this->paginate('Call'));
    $this->set("title_for_layout",  $title_for_layouts);

    if (!empty($subCategories)) {
      $subCats = Set::extract("{n}.Category.name", $subCategories);
      $catDesc = implode(', ', $subCats);
    } else {
      $catDesc = $topPundit['Category']['name'];
    }
    if (($allCategoriesData[0]['Category']['parent_id']) != 0) {
      $parentCategory = $this->Category->getPunditCategoryData($allCategoriesData[0]['Category']['parent_id']);
    } else {
      $parentCategory[0]['Category']['name'] = $topPundit['Category']['name'];
    }
    $this->set('metaDescription', "See our grades for {$catDesc} and other {$parentCategory[0]['Category']['name']} pundits. Can you do better?");

  }//end live_call()


  /**
   * Method is used to view all category related archive calls
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function archive_call($categoryId = null)
  {
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }

    $allCategoriesData = $this->Category->getPunditCategoryData($categoryId);
    $this->set('allCategoriesData', $allCategoriesData);

    $selectedTab = 'archiveCalls';

    // Find the children of this category, if any
    $subCategories = $this->Category->children($categoryId);
    $catIds = array();
    if (!empty($subCategories)) {
      $catIds = Set::extract("{n}.Category.id", $subCategories);
    }
    $catIds[] = $categoryId;

    $this->paginate = array(
      'conditions' => array(
        'category_id' => $catIds,
        'approved' => 1,
        'outcome_id NOT' => null,
        //'vote_end_date <' => date('Y-m-d H:i:s')
      ),
      'contain' => array(
        'User',
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          )
        )
      ),
      'order' => 'CallDummy.created DESC',
      'limit' => 20,
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

    $this->set('archiveCallData', $this->paginate('CallDummy'));
    $topPundit = $this->Category->getTopPundit($categoryId, 3);
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    if(($topPundit['Category']['name']) == "SPORTS") {
      $title_for_layouts = "{$topPundit['Category']['name']} Picks &amp; Predictions";
    } elseif (($topPundit['Category']['id']) == 16) {
        $title_for_layouts = "NCAA College Football: Picks &amp; Predictions";
    } elseif (($topPundit['Category']['id']) == 12) {
        $title_for_layouts = "NCAA College Basketball & March Madness: Picks &amp; Predictions";
    } elseif (($topPundit['Category']['parent_id']) == 3) {
        $title_for_layouts = "{$topPundit['Category']['name']} Picks &amp; Predictions";
    } else {
        $title_for_layouts = "{$topPundit['Category']['name']} Predictions &amp; Picks";
    }
    $this->set("title_for_layout", $title_for_layouts);
    // Find the children of this category, if any
    $subCategories = $this->Category->children($categoryId);

    if (!empty($subCategories)) {
      $subCats = Set::extract("{n}.Category.name", $subCategories);
      $catDesc = implode(', ', $subCats);
    } else {
      $catDesc = $topPundit['Category']['name'];
    }

    $canonicalUrl = array(
      'action' => 'view',
      $topPundit['Category']['slug'],
    );
     if (($allCategoriesData[0]['Category']['parent_id']) != 0) {
      $parentCategory = $this->Category->getPunditCategoryData($allCategoriesData[0]['Category']['parent_id']);
    } else {
      $parentCategory[0]['Category']['name'] = $topPundit['Category']['name'];
    }
    $this->set('metaDescription', "See our grades for {$catDesc} and other {$parentCategory[0]['Category']['name']} pundits. Can you do better?");
    $this->set(compact('selectedTab', 'categoryId', 'topPundit', 'topUser', 'outcomes', 'canonicalUrl'));
  }//end archive_call()


  /**
   * Method to create slug
   *
   * @return void
   */
  function admin_slug() {
    $this->layout = false;
    $this->autoRender = false;
    $categories = $this->Category->find('list',array('fields' => array('id', 'name')));
    foreach ($categories as $id => $name) {
      $data = array();
      $data['Category']['name'] = $name;
      $this->Category->id = $id;
      $this->Category->save($data);
    }
    print("DONE");

  }//end admin_slug


  /**
   * Method is used to view all category related live calls
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
  public function all_call($categoryId = null)
  {

    if ($this->request->is('ajax')) {
      $this->layout = false;
    }

    $allCategoriesData = $this->Category->getPunditCategoryData($categoryId);
    $this->set('allCategoriesData', $allCategoriesData);

    $selectedTab = 'liveCalls';

    $topPundit = $this->Category->getTopPundit(null, 3);


    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('selectedTab', 'categoryId', 'topPundit', 'topUser', 'outcomeData', 'outcomes'));

    $userId = ($this->Auth->user('id') ? $this->Auth->user('id') : 0);

    $options = array(
      'conditions' => array(
        //'Call.category_id' => $categoryId,
        'approved' => 1,
        'OR' => array(
         // 'vote_end_date >=' => date('Y-m-d H:i:s'),
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
        'Call.vote_end_date >=' => date('Y-m-d'),
      ),
      'contain' => array(
        'User',
        'Vote' => array(
          'conditions' => array(
            'Vote.user_id' => array($userId, NULL),
          ),
          //'order' => 'FIELD(Vote.user_id, "", '.$userId.') ASC',
        ),
        'Category'
      ),
      'fields' => array(
        '*',
        '(CASE
          WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()
            THEN 1              /***** Have not voted yet, but able to vote *******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date > NOW()
            THEN 2              /***** Have voted and able not change ******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date < NOW()
            THEN 3              /***** Have voted and not able to change******/
          ELSE 4                /***** Not able to vote on *******/
        END) AS priority',
      ),
      'limit' => 20,
    );

    /*$options['order'] = 'CASE WHEN Vote.user_id IS NULL
      AND Call.vote_end_date > NOW()
      THEN 0 WHEN Vote.user_id IS NOT NULL
      THEN 1 ELSE 2
      END, Call.vote_end_date DESC, Call.created DESC';*/
    /*$options['order'] = 'CASE
      WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()  /***** Have not voted yet, but able to vote *******
        THEN Call.vote_end_date ASC
      WHEN Vote.user_id IS NOT NULL                             /***** Have voted ******
        THEN Call.vote_end_date ASC
      WHEN Call.vote_end_date <= NOW()                          /***** Not able to vote on *******
        THEN Call.created DESC
      END';*/
    $options['order'] = 'priority ASC,
    CASE WHEN priority != 4
      THEN Call.vote_end_date
    END ASC,
    CASE WHEN priority = 4
      THEN Call.created
    END DESC';

    $this->paginate = $options;
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

    $canonicalUrl = array(
      'action' => 'view',
      ($categoryId == 'all') ? "all" : $topPundit['Category']['slug'],
    );

    $this->set(compact('subCategories', 'canonicalUrl'));
    $this->set('liveCallData', $this->paginate('Call'));
    $this->set("title_for_layout", "All Predictions &amp; Picks");
    // Find the children of this category, if any
    $subCategories = $this->Category->find('list', array('conditions' => array('parent_id' => '0')));

    if (!empty($subCategories)) {
      $catDesc = implode(', ', $subCategories);
    } else {
      $catDesc = 'all';
    }
   
    $this->set('metaDescription', "See our grades for {$catDesc} pundits. Can you do better?");

  }//end live_call()

   /**
   * Method is used to view all category related live and archive calls
   *
   * @param integer $categoryId category id
   *
   * @return void
   */
   public function live_archive_call($categoryId = null)
  {
    if(isset($this->params['named']['sort'])) {
      $controller = $this->params['controller'];
      $parameter  = $this->params['pass'][0];
      $this->redirect(array(
        'controller' => $controller, 
        'action' => 'view', $parameter, 
        ), 
      301
      );
    }
    if ($this->request->is('ajax')) {
      $this->layout = false;
    }
    $allCategoriesData = $this->Category->getPunditCategoryData($categoryId);
    $this->set('allCategoriesData', $allCategoriesData);

    $selectedTab = 'liveCalls';

    $topPundit = $this->Category->getTopPundit($categoryId, 3);

    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set(compact('selectedTab', 'categoryId', 'topPundit', 'topUser', 'outcomeData', 'outcomes'));

    $userId = ($this->Auth->user('id') ? $this->Auth->user('id') : 0);

    // Find the children of this category, if any
    $subCategories = $this->Category->children($categoryId);
    $catIds = array();
    if (!empty($subCategories)) {
      $catIds = Set::extract("{n}.Category.id", $subCategories);
    }
    $catIds[] = $categoryId;

    $options = array(
      'conditions' => array(
        'Call.category_id' => $catIds,
        'approved' => 1,
        'OR' => array(
         // 'vote_end_date >=' => date('Y-m-d H:i:s'),
          array('outcome_id' => null),
          array('outcome_id' => 0)
        ),
      ),
      'contain' => array(
        'User',
        'Vote' => array(
          'conditions' => array(
            'Vote.user_id' => array($userId, NULL),
          ),
          //'order' => 'FIELD(Vote.user_id, "", '.$userId.') ASC',
        ),
        'Category'
      ),
      'fields' => array(
        '*',
        '(CASE
          WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()
            THEN 1              /***** Have not voted yet, but able to vote *******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date > NOW()
            THEN 2              /***** Have voted and able not change ******/
          WHEN Vote.user_id IS NOT NULL AND Call.vote_end_date < NOW()
            THEN 3              /***** Have voted and not able to change******/
          ELSE 4                /***** Not able to vote on *******/
        END) AS priority',
      ),
      'limit' => 10,
    );

    /*$options['order'] = 'CASE WHEN Vote.user_id IS NULL
      AND Call.vote_end_date > NOW()
      THEN 0 WHEN Vote.user_id IS NOT NULL
      THEN 1 ELSE 2
      END, Call.vote_end_date DESC, Call.created DESC';*/
    /*$options['order'] = 'CASE
      WHEN Vote.user_id IS NULL AND Call.vote_end_date > NOW()  /***** Have not voted yet, but able to vote *******
        THEN Call.vote_end_date ASC
      WHEN Vote.user_id IS NOT NULL                             /***** Have voted ******
        THEN Call.vote_end_date ASC
      WHEN Call.vote_end_date <= NOW()                          /***** Not able to vote on *******
        THEN Call.created DESC
      END';*/
    $options['order'] = 'priority ASC,
    CASE WHEN priority != 4
      THEN Call.vote_end_date
    END ASC,
    CASE WHEN priority = 4
      THEN Call.created
    END DESC';

    $this->paginate = $options;
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

    $canonicalUrl = array(
      'action' => 'view',
      $topPundit['Category']['slug'],
    );
    $this->set(compact('subCategories' /* 'canonicalUrl'*/));
    $this->set('liveCallData', $this->paginate('Call'));
    if(($topPundit['Category']['name']) == "SPORTS") {
      $title_for_layouts = "{$topPundit['Category']['name']} Picks &amp; Predictions";
    } elseif (($topPundit['Category']['id']) == 16) {
        $title_for_layouts = "NCAA College Football: Picks &amp; Predictions";
    } elseif (($topPundit['Category']['id']) == 12) {
        $title_for_layouts = "NCAA College Basketball & March Madness: Picks &amp; Predictions";
    } elseif (($topPundit['Category']['parent_id']) == 3) {
        $title_for_layouts = "{$topPundit['Category']['name']} Picks &amp; Predictions";
    } else {
        $title_for_layouts = "{$topPundit['Category']['name']} Predictions &amp; Picks";
    }
    $this->set("title_for_layout", $title_for_layouts);
    if (($allCategoriesData[0]['Category']['parent_id']) != 0) {
      $parentCategory = $this->Category->getPunditCategoryData($allCategoriesData[0]['Category']['parent_id']);
    } else {
      $parentCategory[0]['Category']['name'] = $topPundit['Category']['name'];
    }
    if (!empty($subCategories)) {
      $subCats = Set::extract("{n}.Category.name", $subCategories);
      $catDesc = implode(', ', $subCats);
    } else {
      $catDesc = $topPundit['Category']['name'];
    }
    $this->set('metaDescription', "See our grades for {$catDesc} pundits and other {$parentCategory[0]['Category']['name']} pundits. Can you do better?");

    $allCategoriesData = $this->Category->getPunditCategoryData($categoryId);
    $this->set('allCategoriesData', $allCategoriesData);

    $selectedTab = 'archiveCalls';

    // Find the children of this category, if any
    $subCategories = $this->Category->children($categoryId);
    $catIds = array();
    if (!empty($subCategories)) {
      $catIds = Set::extract("{n}.Category.id", $subCategories);
    }
    $catIds[] = $categoryId;

    $this->paginate = array(
      'conditions' => array(
        'category_id' => $catIds,
        'approved' => 1,
        'outcome_id NOT' => null,
        //'vote_end_date <' => date('Y-m-d H:i:s')
      ),
      'contain' => array(
        'User',
        'Vote' => array(
          'conditions' => array(
            'user_id' => $this->Auth->user('id')
          )
        )
      ),
      'order' => 'CallDummy.created DESC',
      'limit' => 10,
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
    $this->set('archiveCallData', $this->paginate('CallDummy'));

    $topPundit = $this->Category->getTopPundit($categoryId, 3);
    $outcomes = $this->Outcome->find('list', array('fields' => array('id', 'title')));
    $this->set("title_for_layout", $title_for_layouts);
    // Find the children of this category, if any
    $subCategories = $this->Category->children($categoryId);

    if (!empty($subCategories)) {
      $subCats = Set::extract("{n}.Category.name", $subCategories);
      $catDesc = implode(', ', $subCats);
    } else {
      $catDesc = $topPundit['Category']['name'];
    }

    $canonicalUrl = array(
      'action' => 'view',
      $topPundit['Category']['slug'],
      'archive' => true,
    );

    $this->set('metaDescription', "See our grades for {$catDesc} and other {$parentCategory[0]['Category']['name']} pundits. Can you do better?");
    $this->set(compact('selectedTab', 'categoryId', 'topPundit', 'topUser', 'outcomes' /*'canonicalUrl'*/));
    $this->set('live_archive_call','live_archive_call');
  }//end live_archive_call()



}//end class
