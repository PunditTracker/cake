<?php
App::uses('PunditsController', 'Controller');

/**
 * TestPunditsController *
 */
class TestPunditsController extends PunditsController 
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
 * PunditsController Test Case
 *
 */
class PunditsControllerTestCase extends ControllerTestCase 
{
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.pundit', 
    'app.user', 
    'app.call', 
    'app.category', 
    'app.pundit_category', 
    'app.outcome', 
    'app.vote', 
    'app.call_dummy'
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Pundits = new TestPunditsController();
    $this->Pundits->constructClasses();

    $this->Pundits->Session->delete('Auth');
    $this->Pundits->Session->delete('parent_id');
    $this->Pundits->Session->delete('parent_group');
    $this->Pundits->Session->delete('flash');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Pundits);

    parent::tearDown();
  }

  /**
   * testIndex method
   *
   * @return void
   */
  public function testIndex() {
    $result = $this->testAction('/pundits/index/3', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'categories' => array(
        1 => 'FINANCE',
        2 => 'POLITICS',
        3 => 'SPORTS'
      )
    );
    $this->assertEquals($expected['categories'], $result['categories']);
  }


  /**
   * testProfile method
   *
   * @return void
   */
  public function testProfile() {
    $result = $this->testAction('/pundits/profile/5', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'userInfo' => array(
        'Pundit' => array(
          'id' => '2'
        ),
      )
    );
    $this->assertEquals($expected['userInfo']['Pundit']['id'], $result['userInfo']['Pundit']['id']);

    $result = $this->testAction('/pundits/profile/100', array('method' => 'get'));
    $this->assertEquals(null, $result);

    try {
      $this->testAction('/pundits/profile/', array('method' => 'get'));
    } catch (Exception $e)  {
      $expected1 = 'Method Not Allowed';
      $this->assertEquals($expected1, $e->getMessage());
    }

  }


  /**
   * testLiveCall method
   *
   * @return void
   */
  public function testLiveCall() {
    $result = $this->testAction('/pundits/live_call/5', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'userInfo' => array(
        'Pundit' => array(
          'id' => '2'
        ),
      )
    );
    $this->assertEquals($expected['userInfo']['Pundit']['id'], $result['userInfo']['Pundit']['id']);
  }


  /**
   * testArchiveCall method
   *
   * @return void
   */
  public function testArchiveCall() {
    $result = $this->testAction('/pundits/archive_call/4', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'userInfo' => array(
        'Pundit' => array(
          'id' => '1'
        ),
      )
    );
    $this->assertEquals($expected['userInfo']['Pundit']['id'], $result['userInfo']['Pundit']['id']);
  }


  /**
   * testHistory method
   *
   * @return void
   */
  public function testHistory() 
  {
    $result = $this->testAction('/pundits/history/4', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'userInfo' => array(
        'User' => array(
          'id' => '4'
        )
      )
    );
    $this->assertEquals($expected['userInfo']['User']['id'], $result['userInfo']['User']['id']);
  
  }


  /**
   * testCategoryList method
   *
   * @return void
   */
  public function testCategoryList() 
  {
    $result = $this->testAction('/pundits/categoryList/4', array('method' => 'ajax'));
    $result = json_decode($result, true);
    $expected = array(
      2 => 'POLITICS'
    );
    $this->assertEquals($expected, $result);
  
  }


  /**
   * testPunditList method
   *
   * @return void
   */
  public function testPunditList() {
    $this->Pundits->Session->write('Auth.User', array(
      'id' => '3',
      'userGroup' => 'General',
      )
    );
    $result = $this->testAction('/pundits/punditList/3', array('method' => 'ajax'));
    $result = json_decode($result, true);
    $expected = array(
      5 => 'Triple H'
    );
    $this->assertEquals($expected, $result);

    $result = $this->testAction('/pundits/punditList/', array('method' => 'ajax'));
    $expected = '[]';
    $this->assertEquals($expected, $result);
  }


  /**
   * testAdminEditInfo method
   *
   * @return void
   */
  public function testAdminEditInfo() 
  {
    $this->Pundits->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    $data = array(
      'User' => array(
        'featured' => '1',
        'id' => '4',
        'fb_id' => '',
        'first_name' => 'Red',
        'last_name' => 'Boss',
        'email' => '',
        'biography' => 'I m money maker',
        'filename' => array(
          'name' => '',
          'type' => '',
          'tmp_name' => '',
          'error' => 1,
          'size' => 0
        )
      )
    );
    $this->testAction('/admin/pundits/edit_info/4', array('method' => 'post', 'data' => $data));
    
    $data = array(
      'User' => array(
        'featured' => '1',
        'id' => '4',
        'fb_id' => '',
        'first_name' => 'Bill',
        'last_name' => 'Gates',
        'email' => '',
        'biography' => 'I m money maker',
        'filename' => array(
          'name' => '',
          'type' => '',
          'tmp_name' => '',
          'error' => 4,
          'size' => 0
        )
      )
    );
    $this->testAction('/admin/pundits/edit_info/4', array('method' => 'post', 'data' => $data));
    $result = $this->Pundits->Session->read('Message.flash.message');
    $expected = 'The Pundit information has been updated.';
    $this->assertEquals($expected, $result);

    try {
      $this->testAction('/admin/pundits/edit_info/100', array('method' => 'get'));
    } catch (Exception $e)  { 
      $expected1 = 'Invalid User';
      $this->assertEquals($expected1, $e->getMessage());
    }
    
    $result = $this->testAction('/admin/pundits/edit_info/4', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'className' => 'hide'
    );
    $this->assertEquals($expected['className'], $result['className']);
  }
}
