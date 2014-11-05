<?php
class PunditScoreShell extends AppShell {
    
  public $uses = array('Call', 'Pundit');
  
  public function main() {
    
    $punditIds = $this->Pundit->find('list', array('fields' => array('id', 'user_id')));
        
    if ($punditIds == '0') {
      $this->out("Pundit not found. Please try again after some time");
      exit;      
    }    
    
    $countPundit = count($punditIds);
    
    $i = $j = 0;
    foreach($punditIds as $keyP => $punditId) {
      $i++;
      //saving avg score in pundits table
      $punditData['score'] = $this->Call->punditScore($punditId);
      //saving avg boldness in pundits table
      $punditData['avg_boldness'] = $this->Call->punditBoldness($punditId);
      //saving avg score in pundits table
      $punditData['calls_graded'] = $this->Call->punditCallsGraded($punditId);
      //saving avg score in pundits table
      $punditData['calls_correct'] = $this->Call->punditCorrectCall($punditId);
     
      $this->Pundit->id = $keyP;
      if ($this->Pundit->save($punditData)) {
        $j++;
        $this->out("Pundit score has been updated for id #$keyP");        
      }
      
    }
    
    $this->out("Total Number Of Pundit : #$countPundit");
    $this->out("Total Number Of Iteration : #$i");
    $this->out("Total Number Of Success : #$j");
    $this->out("Number Of Fails : #".($i - $j));    
        
  }
  
}
