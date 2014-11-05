<?php
App::uses('OutcomesController', 'Controller');

/**
 * TestOutcomesController *
 */
class TestOutcomesController extends OutcomesController 
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
 * OutcomesController Test Case
 *
 */
class OutcomesControllerTestCase extends ControllerTestCase 
{
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.outcome');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() 
  {
    parent::setUp();
    $this->Outcomes = new TestOutcomesController();
    $this->Outcomes->constructClasses();
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Outcomes);

    parent::tearDown();
  }

  /**
   * testAdminIndex method
   *
   * @return void
   */
  public function testAdminIndex() 
  {
    $result = $this->testAction('/admin/outcomes/index/', array('method' =>'get'));
    //debug($result);
  }


  /**
   * testAdminAdd method
   *
   * @return void
   */
  public function testAdminAdd() 
  {
    $data = array(
      'Outcome' => array(
        'title' => 'new',
        'rating' => '1'
      )
    );
    $this->testAction('/admin/outcomes/add/', array('method' =>'post', 'data' => $data));
    $result = $this->Outcomes->Session->read('Message.flash.message');
    $expected = 'The outcome has been saved';  
    $this->assertEquals($expected, $result);

    $data = array(
      'Outcome' => array(
        'title' => '',
        'rating' => '1'
      )
    );
    $this->testAction('/admin/outcomes/add/', array('method' =>'post', 'data' => $data));
    $result = $this->Outcomes->Session->read('Message.flash.message');
    $expected = 'The outcome could not be saved. Please, try again.';  
    $this->assertEquals($expected, $result);
  }


  /**
   * testAdminEdit method
   *
   * @return void
   */
  public function testAdminEdit() 
  {
    $this->testAction('/admin/outcomes/edit/4', array('method' =>'get'));

    $data = array(
      'Outcome' => array(
        'title' => 'updated outcome',
        'rating' => '1'
      )
    );
    $this->testAction('/admin/outcomes/edit/4', array('method' =>'post', 'data' => $data));
    $result = $this->Outcomes->Session->read('Message.flash.message');
    $expected = 'The Outcome has been updated';  
    $this->assertEquals($expected, $result);

    $data = array(
      'Outcome' => array(
        'title' => '',
        'rating' => '1'
      )
    );
    $this->testAction('/admin/outcomes/edit/4', array('method' =>'post', 'data' => $data));
    $result = $this->Outcomes->Session->read('Message.flash.message');
    $expected = 'The Outcome could not updated. Please, try again.';  
    $this->assertEquals($expected, $result);

    try {
      $this->testAction('/admin/outcomes/edit/100', array('method' =>'get'));
    } catch (Exception $e)  {
      $expected1 = 'Invalid Outcome';
      $this->assertEquals($expected1, $e->getMessage());
    }
    
  }


  /**
   * testAdminDelete method
   *
   * @return void
   */
  public function testAdminDelete() 
  {
    $this->testAction('/admin/outcomes/delete/4', array('method' =>'post'));
    $result = $this->Outcomes->Session->read('Message.flash.message');
    $expected = 'Outcome deleted';  
    $this->assertEquals($expected, $result);

    try {
      $this->testAction('/admin/outcomes/delete/100', array('method' =>'post'));
    } catch (Exception $e)  {
      $expected1 = 'Invalid Outcome';
      $this->assertEquals($expected1, $e->getMessage());
    }
  }
}
