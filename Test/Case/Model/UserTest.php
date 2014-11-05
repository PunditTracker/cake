<?php
App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.user', 'app.call', 'app.category', 'app.pundit', 'app.pundit_category', 'app.outcome', 'app.vote');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->User = ClassRegistry::init('User');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->User);

    parent::tearDown();
  }
  
  /** 
   * testUpdateUsername method 
   * 
   * @return void 
   */
  public function testUpdateUsername() { 
    $data = array(
      'id' => '2',
      'first_name' => 'heer',
      'last_name' => 'fire'
    );    
    $this->User->updateUsername($data);  
  } 

}
