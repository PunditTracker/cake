<?php
App::uses('CallDummy', 'Model');

/**
 * CallDummy Test Case
 *
 */
class CallDummyTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.call_dummy', 'app.user', 'app.call', 'app.category', 'app.pundit', 'app.pundit_category', 'app.outcome', 'app.vote');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->CallDummy = ClassRegistry::init('CallDummy');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->CallDummy);

    parent::tearDown();
  }

}
