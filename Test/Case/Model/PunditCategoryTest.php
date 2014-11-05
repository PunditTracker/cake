<?php
App::uses('PunditCategory', 'Model');

/**
 * PunditCategory Test Case
 *
 */
class PunditCategoryTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.pundit_category');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->PunditCategory = ClassRegistry::init('PunditCategory');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->PunditCategory);

    parent::tearDown();
  }

}
