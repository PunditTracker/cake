<?php
class UserScoreShell extends AppShell {
    
  public $uses = array('Vote');
  
  public function main() {
    $days = configure::read('call_graded_time');
    
    $option = array(
      'fields' => array('id'),
      'conditions' => array(
        'Call.modified >' => date('Y-m-d H:i:s', strtotime("$days")),
        'Call.outcome_id NOT' => null    
      )     
    );   
    $callIds = $this->Vote->Call->find('list', $option);
    $numberOfCall = count($callIds);
    if ($numberOfCall == '0') {
      $this->out("Call not found. Please try again after some time");
      exit;      
    }
    $option = array(        
      'conditions' => array(
        'Vote.call_id' => $callIds
      ),
      'contain' => array(
        'User' => array(
          'fields' => 'id'
        ),
        'Call' => array(
          'fields' => array(
            'id', 
            'outcome_id', 
            'ptvariable', 
            'yield', 
            'boldness',
            'modified'
          ), 'Outcome'
        )
      ),
      'order' => 'Vote.call_id'
    );
    $usersOnCall = $this->Vote->find('all', $option);     
    if ($this->Vote->gradeUserVote($usersOnCall)) {
      $this->out("$numberOfCall calls related user's score has been updated");
    }
    
  }
}
