<?php
App::uses('Outcome', 'Model');

/**
 * Outcome Test Case
 *
 */
class OutcomeTestCase extends CakeTestCase {
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
  public function setUp() {
    parent::setUp();
    $this->Outcome = ClassRegistry::init('Outcome');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Outcome);

    parent::tearDown();
  }

}
