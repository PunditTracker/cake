<?php
App::uses('Call', 'Model');

/**
 * Call Test Case
 *
 */
class CallTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.call', 'app.user', 'app.vote', 'app.category', 'app.pundit', 'app.pundit_category', 'app.outcome');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Call = ClassRegistry::init('Call');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Call);

    parent::tearDown();
  }

}
