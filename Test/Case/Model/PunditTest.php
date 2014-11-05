<?php
App::uses('Pundit', 'Model');

/**
 * Pundit Test Case
 *
 */
class PunditTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.pundit', 'app.user', 'app.call', 'app.category', 'app.pundit_category', 'app.outcome', 'app.vote');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Pundit = ClassRegistry::init('Pundit');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Pundit);

    parent::tearDown();
  }

}
