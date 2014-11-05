<?php
App::uses('CallsController', 'Controller');

/**
 * TestCallsController *
 */
class TestCallsController extends CallsController 
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
 * CallsController Test Case
 *
 */
class CallsControllerTestCase extends ControllerTestCase 
{
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.call', 
    'app.user', 
    'app.vote', 
    'app.category', 
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
  public function setUp() 
  {
    parent::setUp();
    $this->Calls = new TestCallsController();
    $this->Calls->constructClasses();
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() 
  {
    unset($this->Calls);

    parent::tearDown();
  }

  /**
   * testAdminIndex method
   *
   * @return void
   */
  public function testAdminIndex() 
  {
    $this->Calls->Session->write('Auth.User',
      array(
        'id' => '1',
        'userGroup' => 'Admin',       
      )
    );
    
    $result = $this->testAction(
      '/admin/calls/index',
        array('method' => 'get', 'return' => 'vars')
    );     
    $expected['id'] = '4';
    $expected['prediction'] = 'Bill gates will open microsoft in Moon';    
    $this->assertEquals($expected['id'], $result['calls'][0]['Call']['id']);
    $this->assertEquals($expected['prediction'], $result['calls'][0]['Call']['prediction']);
   
  }
  
  
  /**
   * testAdminDelete method
   *
   * @return void
   */
  public function testAdminDelete() 
  {
    $result = $this->testAction('admin/calls/delete/4', array('method' => 'post'));
    
    $expected = 'The Prediction has been deleted.' ;
    
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));
  
    try {
      $this->testAction('admin/calls/delete/1000', array('return' => 'result'));
    }  catch (Exception $e)  {
      $expected = 'Invalid Call';
      $this->assertEquals($expected, $e->getMessage());
    }
    
    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';  
    $result = $this->testAction('admin/calls/delete/5');
    
    $expected = 'The Prediction has been deleted.' ;
    
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));
      
  }
  
  /**
   * testAdd method
   *
   * @return void
   */
  public function testAdd() 
  {
    $this->Calls->Session->write('Auth.User', 
      array(
        'id' => '2',
        'userGroup' => 'General',
        )
    );
    $validData = array(
      'Call' => array(
        'user_id' => '4',
        'category_id' => '2',
        'source' => 'BBC',        
      )
    );

    $result = $this->testAction('calls/add', array('return' => 'result', 'data' => $validData));
    $expected = 'The Prediction has been Suggested';  
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));
    
    //method not allowed
    $inValidData = array(
      'Call' => array(
        'user_id' => '5',
        'category_id' => '2',     
        'source' => ''
      )
    );    
    try {
      $this->testAction('calls/add', array('return' => 'result', 'data' => $inValidData));
    }  catch (Exception $e)  {
      $expected = 'Method Not Allowed';
      $this->assertEquals($expected, $e->getMessage());
    }   
    
    //method not allowed
    $inValidData = array(
      'Call' => array(
        'user_id' => '',
        'category_id' => '2',     
        'source' => ''
      )
    );    
    $result = $this->testAction('calls/add', array('data' => $inValidData));
    
  }
    
  
  /**
   * testAdminAdd method
   *
   * @return void
   */
  public function testAdminAdd() 
  {
    $this->Calls->Session->write('Auth.User',
      array(
        'id' => '1',
        'userGroup' => 'Admin',       
      )
    );
    
    //with category
    $validData = array(
      'Call' => array(
        'user_id' => '4', 
        'category_id' => '2',           
        'source' => 'BBC',        
      )
    );
    $this->testAction('admin/calls/add', array('return' => 'result', 'data' => $validData));
    $expected = 'The Prediction has been saved';  
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));
    
    //without category
    $validData = array(
      'Call' => array(
        'user_id' => '4',             
        'source' => 'BBC',        
      )
    );
    $this->testAction('admin/calls/add', array('return' => 'result', 'data' => $validData));
    $expected = 'The Prediction has been saved';  
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));
    //if pundit already selected
   
    $this->testAction('admin/calls/add/4', array('return' => 'vars', 'method' => 'get'));
      
  }
  
  /**
   * testAdminEdit method
   *
   * @return void
   */
  public function testAdminEdit() 
  {
    try {
      $this->testAction('admin/calls/edit/55', array('method' => 'get', 'return' => 'result'));
    }  catch (Exception $e)  {      
      $expected = 'Invalid Prediction Suggestion';
      $this->assertEquals($expected, $e->getMessage());
    }
    
    $result = $this->testAction('admin/calls/edit/4', array('return' => 'vars', 'method' => 'get'));
    $expected = '4';  
    $this->assertEquals($expected, $result['predictionId']);    
    
   
    $validData = array(
      'Call' => array(
        'is_calculated' => true,
        'outcome_id' => 5,
        'ptvariable' => 1,     
        'category_id' => 3,
        'user_id' => 5
      )
    );
    $result = $this->testAction('admin/calls/edit/2', array('data' => $validData));
    
    $expected = 'The Prediction has been saved';
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));  
   
    $validData = array(
      'Call' => array(
        'is_calculated' => true,
        'outcome_id' => 2,
        'ptvariable' => 0.5,     
        'category_id' => 3,
        'user_id' => 5
      )
    );
    $result = $this->testAction('admin/calls/edit/2', array('data' => $validData));
        
    $notApprovedData = array(
      'Call' => array(
        'user_id' => '4',
        'category_id' => '2',        
        'created' => '08/31/12',
        'due_date' => '12/31/13',
        'vote_end_date' => '10/19/12',              
        'is_calculated' => '0'
      )
    );
    $result = $this->testAction('admin/calls/edit/4', array('data' => $notApprovedData));
       
    $expected = 'The Prediction has been saved';
    $this->assertEquals($expected, $this->Calls->Session->read('Message.flash.message'));  
   
  }
  
     
  /**
   * testAdminApprove method
   *
   * @return void
   */
  public function testAdminApprove() 
  {
    $this->Calls->Session->write('Auth.User',
      array(
        'id' => '1',
        'userGroup' => 'Admin',       
      )
    );
   
    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';  

    $result = $this->testAction('/admin/calls/approve/4');  
    $result = json_decode($result);
   
    $expected = 'Please select Vote End Date and Due Date first !!!';  
    $this->assertEquals($expected, $result->message);
    
    $result = $this->testAction('/admin/calls/approve/6');  
    $result = json_decode($result);
   
    $expected = 'Prediction approved';  
    $this->assertEquals($expected, $result->message);
        
  } 
  
 
  /**
   * testHistory method
   *
   * @return void
   */
  public function testHistory() 
  {
     $result = $this->testAction('calls/history/2', array('method' => 'get', 'return' => 'vars'));
     $expected = 'POLITICS';
     $this->assertEquals($expected, $result['categoryName']);  
  }
  
}
