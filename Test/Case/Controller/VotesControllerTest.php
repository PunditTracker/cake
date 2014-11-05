<?php
App::uses('VotesController', 'Controller');

/**
 * TestVotesController *
 */
class TestVotesController extends VotesController 
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
 * VotesController Test Case
 *
 */
class VotesControllerTestCase extends ControllerTestCase 
{
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.vote', 
    'app.user', 
    'app.call', 
    'app.category', 
    'app.pundit', 
    'app.pundit_category', 
    'app.outcome'
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() 
  {
    parent::setUp();
    $this->Votes = new TestVotesController();
    $this->Votes->constructClasses();
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Votes);

    parent::tearDown();
  }

  /**
   * testAdd method
   *
   * @return void
   */
  public function testAdd() 
  {
    $this->Votes->Session->write('Auth.User', array(
      'id' => '3',
      'userGroup' => 'General',
      )
    );

    $data = array(
      'Vote' => array(
        'rate' => array(
          1 => '-1'
        ),
        'call_id' => '1'
      )
    );
    $this->testAction('/votes/add/1', array('data' => $data, 'method' => 'post'));
    $result = $this->Votes->Session->read('Message.flash.message');
    $expected = 'Thank you for voting' ;  
    $this->assertEquals($expected, $result);

    $data['Vote'] = array();
    $result = $this->testAction('/votes/add/1', array('data' => $data, 'method' => 'post'));
    $expected = null ;  
    $this->assertEquals($expected, $result);

    $data = array(
      'Vote' => array(
        'rate' => array(
          2 => '0.5'
        ),
        'call_id' => '2'
      )
    );
    $this->testAction('/votes/add/2', array('data' => $data, 'method' => 'post'));
    $result = $this->Votes->Session->read('Message.flash.message');
    $expected = 'Thank you for voting' ;  
    $this->assertEquals($expected, $result);

    $data = array(
      'Vote' => array(
        'rate' => array(
          3 => '0.5'
        ),
        'call_id' => '3'
      )
    );
    $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';  
    $result = $this->testAction('/votes/add/3', array('data' => $data));
    $result = json_decode($result);
   
    $expected = 'Thank you for the voting!';  
    $this->assertEquals($expected, $result->message);
    
    $data = array(
      'Vote' => array(
        'rate' => array(
          2 => '1'
        ),
        'call_id' => '2'
      )
    );   
    $result = $this->testAction('/votes/add/2', array('data' => $data));
    $result = json_decode($result);
   
    $expected = 'Thank you for the voting!';  
    $this->assertEquals($expected, $result->message);
    
    $this->Votes->Session->write('Auth.User', array(
      'id' => null
      )
    );
    $result = $this->testAction('/votes/add/3', array());
    $result = json_decode($result);
   
    $expected = 'Vote not added. Please, try again.';  
    $this->assertEquals($expected, $result->message);

  }


}
