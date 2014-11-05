<?php
App::uses('Vote', 'Model');

/**
 * Vote Test Case
 *
 */
class VoteTestCase extends CakeTestCase {
  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array('app.vote', 'app.user', 'app.call', 'app.category', 'app.pundit', 'app.pundit_category', 'app.outcome');

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Vote = ClassRegistry::init('Vote');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Vote);

    parent::tearDown();
  }

 
  /**
   * testGradeUserVote method
   *
   * @return void
   */
  public function testGradeUserVote() {
    
    $data = array(
      0 => array(
        'Vote' => array(
          'id' => '2',
          'call_id' => '7',
          'user_id' => '2',
          'rate' => '0.5',
          'ptvariable' => null,
          'yield' => null,
          'boldness' => null,
          'is_calculated' => false,
          'created' => '2012-08-23 04:49:58',
          'modified' => '2012-08-23 04:49:58'
        ),
        'User' => array(
          'id' => '2'
        ),
        'Call' => array(
          'id' => '7',
          'outcome_id' => '5',
          'ptvariable' => '1.0',
          'yield' => '1.00',
          'boldness' => '0.00',
          'modified' => '2012-08-23 04:50:52',
          'Outcome' => array(
            'id' => '5',
            'title' => 'definitely came true',
            'rating' => '1',
            'created' => '2012-06-05 11:28:31',
            'modified' => '2012-06-05 11:28:33'
          )
        )
      )
    );
    $result = $this->Vote->gradeUserVote($data);
    $expected = true;  
    $this->assertEquals($expected, $result);
    
    $data = array(
      0 => array(
        'Vote' => array(
          'id' => '2',
          'call_id' => '7',
          'user_id' => '2',
          'rate' => '-1',
          'ptvariable' => null,
          'yield' => null,
          'boldness' => null,
          'is_calculated' => false,
          'created' => '2012-08-23 04:49:58',
          'modified' => '2012-08-23 04:49:58'
        ),
        'User' => array(
          'id' => '2'
        ),
        'Call' => array(
          'id' => '7',
          'outcome_id' => '5',
          'ptvariable' => '1.0',
          'yield' => '1.00',
          'boldness' => '0.00',
          'modified' => '2012-08-23 04:50:52',
          'Outcome' => array(
            'id' => '5',
            'title' => 'definitely came true',
            'rating' => '1',
            'created' => '2012-06-05 11:28:31',
            'modified' => '2012-06-05 11:28:33'
          )
        )
      )
    );
    $result = $this->Vote->gradeUserVote($data);
    $expected = true;  
    $this->assertEquals($expected, $result);
    
    $data = array(
      0 => array(
        'Vote' => array(
          'id' => '3',
          'call_id' => '3',
          'user_id' => '2',
          'rate' => '-0.5',
          'ptvariable' => null,
          'yield' => null,
          'boldness' => null,
          'is_calculated' => false,
          'created' => '2012-08-23 04:49:58',
          'modified' => '2012-08-23 04:49:58'
        ),
        'User' => array(
          'id' => '2'
        ),
        'Call' => array(
          'id' => '3',
          'outcome_id' => '4',
          'ptvariable' => '1.0',
          'yield' => '',
          'boldness' => '',
          'modified' => '2012-08-22 04:03:07',
          'Outcome' => array(
            'id' => '4',
            'title' => 'mostly did come true',
            'rating' => '0.5',
            'created' => '2012-06-05 11:28:31',
            'modified' => '2012-06-05 11:28:33'
          )
        )
      )
    );
    $result = $this->Vote->gradeUserVote($data);
    $expected = true;  
    $this->assertEquals($expected, $result);
   
  }
  
}
