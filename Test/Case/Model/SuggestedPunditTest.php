<?php
App::uses('SuggestedPundit', 'Model');

/**
 * SuggestedPundit Test Case
 *
 */
class SuggestedPunditTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.suggested_pundit', 'app.user', 'app.call', 'app.category', 'app.pundit', 'app.pundit_category', 'app.outcome', 'app.vote');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->SuggestedPundit = ClassRegistry::init('SuggestedPundit');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->SuggestedPundit);

    parent::tearDown();
  }
  
  
 /** 
  * testSaveAndApprovePundit method 
  * 
  * @return void 
  */ 
  public function testSaveAndApprovePundit() { 
  
    $this->SuggestedPundit->approveSuggestedPundit('abc', 4564564);
  } 

}
