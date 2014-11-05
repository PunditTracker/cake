<?php
App::uses('CategoriesController', 'Controller');

/**
 * TestCategoriesController *
 */
class TestCategoriesController extends CategoriesController 
{
  /**
   * Auto render
   *
   * @var boolean
   */
  public $autoRender = false;

  /**
   * Redirect action
   *
   * @param mixed $url
   * @param mixed $status
   * @param boolean $exit
   * @return void
   */
  public function redirect($url, $status = null, $exit = true) 
  {
    $this->redirectUrl = $url;
  }
}

/**
 * CategoriesController Test Case
 *
 */
class CategoriesControllerTestCase extends ControllerTestCase 
{
  
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.category', 
    'app.call', 
    'app.user', 
    'app.vote', 
    'app.pundit', 
    'app.pundit_category', 
    'app.outcome', 
    'app.call_dummy'
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Categories = new TestCategoriesController();
    $this->Categories->constructClasses();
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Categories);

    parent::tearDown();
  }

  /**
   * testAdminIndex method
   *
   * @return void
   */
  public function testAdminIndex() {
        
    $result = $this->testAction(
           '/admin/categories/index',
             array('method' => 'get', 'return' => 'vars')
        );   
    $expected['id'] = 1;
    $expected['name'] = 'FINANCE';    
    $this->assertEquals($expected['name'], $result['allCategories'][1]);    
  }
  
  /**
   * testAdminAdd method
   *
   * @return void
   */
  public function testAdminAdd() {
    
    $invalidData = array(
      'Category' => array(
        'name' => ''
      )
    );

    $result = $this->testAction('admin/categories/add', array('return' => 'result', 'data' => $invalidData));
   
    $expected = 'The category could not be saved. Please, try again.';  
    $this->assertEquals($expected, $this->Categories->Session->read('Message.flash.message'));


    $data = array(
      'Category' => array(
        'name' => 'dummy'
      )
    );
    $result = $this->testAction('admin/categories/add', array('return' => 'result', 'data' => $data));
    $expected = 'The category has been saved' ;  
    $this->assertEquals($expected, $this->Categories->Session->read('Message.flash.message'));
    
  }
  
  /**
   * testAdminEdit method
   *
   * @return void
   */
  public function testAdminEdit() {
    try {
      $this->testAction('admin/categories/edit/55', array('method' => 'get', 'return' => 'result'));
    }  catch (Exception $e)  {      
      $expected = 'Invalid Category';
      $this->assertEquals($expected, $e->getMessage());
    }
        
    $invalidData = array(
      'Category' => array(
        'name' => ''
      )
    );
    $result = $this->testAction('admin/categories/edit/1', array('data' => $invalidData, 'method' => 'post', 'return' => 'result'));
    $expected = 'The category could not updated. Please, try again.' ;  
    $this->assertEquals($expected, $this->Categories->Session->read('Message.flash.message'));

    $data = array(
      'User' => array(
        'name' => 'FINANCER'
      )
    );
    $result = $this->testAction('admin/categories/edit/1', array('data' => $data,'method' => 'post', 'return' => 'result'));
    $expected = 'The category has been updated' ;  
    $this->assertEquals($expected, $this->Categories->Session->read('Message.flash.message'));

  }
  
  /**
   * testAdminDelete method
   *
   * @return void
   */
  public function testAdminDelete() {
    
    $result = $this->testAction('admin/categories/delete/1', array('method' => 'post'));
    
    $expected = 'Category deleted' ;
    
    $this->assertEquals($expected, $this->Categories->Session->read('Message.flash.message'));
  
    try {
      $this->testAction('admin/categories/delete/1000', array('return' => 'result'));
    }  catch (Exception $e)  {
      $expected = 'Invalid category';
      $this->assertEquals($expected, $e->getMessage());
    }

  }
  
  /**
   * testView method
   *
   * @return void
   */
  public function testView() {            
    try {
      $this->testAction('categories/view/1000', array('return' => 'result'));
    }  catch (Exception $e)  {  
      $expected = 'Invalid Category';
      $this->assertEquals($expected, $e->getMessage());
    } 
  
  }
  
  /**
   * testLiveCall method
   *
   * @return void
   */
  public function testLiveCall() {
    $result = $this->testAction('categories/live_call/2', array('method' => 'get', 'return' => 'vars'));
    $expected['name'] = 'POLITICS';
    $this->assertEquals($expected['name'], $result['allCategoriesData'][0]['Category']['name']);
  
  }
  
  /**
   *
   * testArchiveCall method
   *
   * @return void
   */
  public function testArchiveCall() {
    $result = $this->testAction('categories/archive_call/2', array('method' => 'get', 'return' => 'vars'));
    $expected['name'] = 'POLITICS';
    $this->assertEquals($expected['name'], $result['allCategoriesData'][0]['Category']['name']);
  
  }
  
}
