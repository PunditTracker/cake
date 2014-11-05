<?php
App::uses('SuggestedPunditsController', 'Controller');

/**
 * TestSuggestedPunditsController *
 */
class TestSuggestedPunditsController extends SuggestedPunditsController 
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
 * SuggestedPunditsController Test Case
 *
 */
class SuggestedPunditsControllerTestCase extends ControllerTestCase 
{
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.suggested_pundit', 
    'app.user', 
    'app.call', 
    'app.category', 
    'app.pundit', 
    'app.pundit_category', 
    'app.outcome', 
    'app.vote'
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() 
  {
    parent::setUp();
    $this->SuggestedPundits = new TestSuggestedPunditsController();
    $this->SuggestedPundits->constructClasses();

    $this->SuggestedPundits->Session->delete('Auth');
    $this->SuggestedPundits->Session->delete('parent_id');
    $this->SuggestedPundits->Session->delete('parent_group');
    $this->SuggestedPundits->Session->delete('flash');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() 
  {
    unset($this->SuggestedPundits);

    parent::tearDown();
  }


  /**
   * testIndex method
   *
   * @return void
   */
  public function testIndex() 
  {
    $result = $this->testAction('/suggested_pundits/index/', array('method' => 'get', 'return' => 'vars'));
    $expected = array(
      'SuggestedPundit' => array(
        0 => array(
          'SuggestedPundit' => array(
            'id' => '1'
          )
        )
      )
    );
    $this->assertEquals($expected['SuggestedPundit'][0]['SuggestedPundit']['id'], $result['SuggestedPundit'][0]['SuggestedPundit']['id']);
  }


  /**
   * testAdd method
   *
   * @return void
   */
  public function testAdd() 
  {
    $this->SuggestedPundits->Session->write('Auth.User', array(
      'id' => '3',
      'userGroup' => 'General',
      )
    );
    $data = array(
      'SuggestedPundit' => array(
        'category_id' => '3',
        'pundit_name' => 'Roger Federer'
      )
    );
    $this->testAction('/suggested_pundits/add/', array('method' => 'post', 'data' => $data));
    $result = $this->SuggestedPundits->Session->read('Message.flash.message');
    $expected = 'The Pundit has been Suggested';
    $this->assertEquals($expected, $result);
  }


  /**
   * testAdminAdd method
   *
   * @return void
   */
  public function testAdminAdd() 
  {
    $this->SuggestedPundits->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    
    $data = array(
      'Pundit' => array(
        'featured' => '1'
      ),
      'User' => array(
        'first_name' => 'yosa',
        'last_name' => 'boo',
        'email' => '',
        'biography' => 'pundit suggestion by admin',
        'filename' => array(
          'name' => '',
          'type' => '',
          'tmp_name' => '',
          'error' => 1,
          'size' => 0,          
        )
      ),
      'Category' => array(
        'category_id' => ''
      )
    );
    $this->testAction('/admin/suggested_pundits/add/', array('method' => 'post', 'data' => $data));
       
    $data = array(
      'Pundit' => array(
        'featured' => '1'
      ),
      'User' => array(
        'first_name' => 'Pundit',
        'last_name' => 'ByAdmin',
        'email' => '',
        'biography' => 'pundit suggestion by admin',
        'filename' => array(
          'name' => '',
          'type' => '',
          'tmp_name' => '',
          'error' => 4,
          'size' => 0,         
        )
      ),
      'Category' => array(
        'category_id' => '3'
      )
    );
    $this->testAction('/admin/suggested_pundits/add/', array('method' => 'post', 'data' => $data));
    $result = $this->SuggestedPundits->Session->read('Message.flash.message');
    $expected = 'The Pundit has been created.';
    $this->assertEquals($expected, $result);
    
    
    $data['SuggestedPundit']['id'] = 5;
    $this->testAction('/admin/suggested_pundits/add/', array('method' => 'post', 'data' => $data));
    $result = $this->SuggestedPundits->Session->read('Message.flash.message');
    $expected = 'The Pundit has been created.';
    $this->assertEquals($expected, $result);
  }


  /**
   * testAdminEdit method
   *
   * @return void
   */
  public function testAdminEdit() 
  {
    $this->SuggestedPundits->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );

    try {
      $this->testAction('/admin/suggested_pundits/edit/100', array('method' => 'get'));
    } catch (Exception $e)  { 
      $expected1 = 'Invalid Pundit Suggestion';
      $this->assertEquals($expected1, $e->getMessage());
    }

    $data = array(
      'SuggestedPundit' => array(
        'pundit_name' => 'Pundit NotApprove2',
        'category_id' => 3
      )
    );
    $this->testAction('/admin/suggested_pundits/edit/5', array('method' => 'post', 'data' => $data));

    $this->testAction('/admin/suggested_pundits/edit/5', array('method' => 'get'));
    $result = $this->SuggestedPundits->Session->read('Message.flash.message');
    $expected = 'The Pundit has been created.';
    $this->assertEquals($expected, $result);
  }


  /**
   * testAdminDelete method
   *
   * @return void
   */
  public function testAdminDelete() 
  {
    $this->SuggestedPundits->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );

    try {
      $this->testAction('/admin/suggested_pundits/delete/5', array('method' => 'get'));
    } catch (Exception $e)  {
      $expected1 = 'Method Not Allowed';
      $this->assertEquals($expected1, $e->getMessage());
    }
    
    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';  
    $result = $this->testAction('/admin/suggested_pundits/delete/5', array());
    $result = json_decode($result);   
    $expected = 'Suggested pundit deleted';  
    $this->assertEquals($expected, $result->message);
    
  }


  /**
   * testAdminIndex method
   *
   * @return void
   */
  public function testAdminIndex() 
  {
    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';  
    $this->SuggestedPundits->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    $result = $this->testAction('/admin/suggested_pundits/index/', array('method' => 'get', 'return' => 'vars'));
    $expected = 'Pundit NotApprove2';  
    $this->assertEquals($expected, $result['allSuggestedPundits'][0]['SuggestedPundit']['pundit_name']);
        
  }


  /**
   * testAdminApprove method
   *
   * @return void
   */
  public function testAdminApprove() 
  {
    $this->SuggestedPundits->Session->write('Auth.User', array(
      'id' => '1',
      'userGroup' => 'Admin',
      )
    );
    try {
      $this->testAction('/admin/suggested_pundits/approve/5', array('method' => 'get'));
    } catch (Exception $e)  {
      $expected1 = 'Method Not Allowed';
      $this->assertEquals($expected1, $e->getMessage());
    }
    
    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';  
    $result = $this->testAction('/admin/suggested_pundits/approve/5', array());
    $result = json_decode($result);    
    $expected = 'Suggested pundit approved';  
    $this->assertEquals($expected, $result->message);    
    
  }


}
