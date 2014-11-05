<?php $options = Configure::read('radio_vote_option'); 
?>
<table class="table_box table_box4" id='userProfileLiveTable'>
  <tr>
    <?php if(isset($live_archive_call)) { ?>
      <th class="col1"><span>Pundit</span></th>
      <th class="col2"><span>Prediction</span></th>
      <th class="col5"><span>Outcome</span></th>  
      <th class="col4"><span>Date Made</span></th>
      <th class="col4"><span>Date Due</span></th>
      <th class="col6"><span>Vote Date</span></th>
      <th class="col6"><span>Vote Until</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col6"><span>My Vote</span></th>
      <th class="last col9"><span>Share</span></th>
    <?php } else {?>
      <th class="col1"><?php echo $this->Paginator->sort('User.first_name', 'Pundit', array('class' => 'sort_down'));?></th>
      <th class="col2"><?php echo $this->Paginator->sort('Call.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
      <th class="col5"><span>Outcome</span></th>  
      <th class="col4"><?php echo $this->Paginator->sort('Call.created', 'Date Made', array('class' => 'sort_down'));?></th>
      <th class="col4"><?php echo $this->Paginator->sort('Call.due_date', 'Date Due', array('class' => 'sort_down'));?></th>    
      <th class="col6"><?php echo $this->Paginator->sort('Vote.created', 'Vote Date', array('class' => 'sort_down'));?></th>
      <th class="col6"><?php echo $this->Paginator->sort('Call.vote_end_date', 'Vote Until', array('class' => 'sort_down'));?></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col6"><span>My Vote</span></th>
      <th class="last col9"><span>Share</span></th>
    <?php } ?>
    
  </tr>
  <?php 
  if (count($userProfileData) == 0) {
  ?>
    <tr>
      <td class="noRecord" colspan='10'>No Records found</td>
    </tr>
  <?php
  } else {
    foreach ($userProfileData as $key => $vote) {
      if (count($vote['Call']) > 0) {
        $outcome = 'TBD';
        if (isset($vote['Call']['outcome_id']) && !empty($vote['Call']['outcome_id'])) {
          switch ($vote['Call']['outcome_id']) {
            case 1:
            case 2:
            case 3:
              $outcome = $this->Html->image(
                'ico_wrong2.png'
              );
              break;
            case 4:
            case 5:
              $outcome = $this->Html->image(
                'ico_right2.png'
              );
              break;
            default:
              $outcome = 'TBD';
          }
        }
        $class = '';
        if (($key % 2) == 0) {
          $class = 'odd';
        } 
        ?>
        <tr class="<?php echo $class; ?>">
          <td>
          <?php 
          echo $this->Html->link(
            $vote['User']['first_name'].' '.$vote['User']['last_name'], 
            array(
              'controller' => 'pundits',
              'action' => 'profile',
              'admin' => false,
              $vote['User']['slug']
            ), 
            array()
          ); 
          ?>
          </td>
          <td class="preFirst"><?php echo $vote['Call']['prediction']; ?></td>
          <td class="td_center"> 
            <?php if($outcome == "TBD" ) {
                    echo $this->Html->image('tbd.png', array('alt' => 'TBD'));;
                  }else {
                    echo $outcome; 
                  }?> 
          </td>          
          <td class="td_center">
              <?php echo $this->PT->dateFormat($vote['Call']['created']); ?>
          </td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($vote['Call']['due_date']); ?>
          </td>         
          <td class="td_center">
            <?php echo $this->PT->dateFormat($vote['Vote'][0]['created']); ?>
          </td>
          <td class="td_center">
            <?php
            if ($vote['Call']['vote_end_date'] >= date('Y-m-d')) { 
              echo $this->PT->dateFormat($vote['Call']['vote_end_date']);
            } else { ?>
              <span class="">Closed</span>
            <?php 
            }           
            ?>           
          </td>
          <td class="td_center">
            <?php if($this->PT->callBoldness($vote['Vote'][0]['boldness'], true) == "TBD" ) {
                    echo $this->Html->image('tbd.png', array('alt' => 'TBD'));;
                  }else {
                    echo $this->PT->callBoldness($vote['Vote'][0]['boldness'], true);
                  }?> 
            
          </td>
          <td class="td_center">
          <?php           
            if (isset($vote['Vote'][0]['rate'])) {                
              if ($currentUserData['User']['id'] == $this->Session->read('Auth.User.id') && $vote['Call']['vote_end_date'] >= date('Y-m-d')) {
                if (!empty($isMobile)) {
                  echo $this->Html->link(
                    $options[$vote['Vote'][0]['rate']], 
                    array(
                      'controller' => 'votes',
                      'action'     => 'add',
                      'admin' => false,
                      $vote['Call']['id'],
                    ),
                    array(
                      'id' => 'call'.$vote['Call']['id'],
                    )
                  );
                } else {
                  echo $this->Html->link(
                    $options[$vote['Vote'][0]['rate']], 
                    '',
                    array(
                      'id' => 'call'.$vote['Call']['id'],
                      'class' => 'editVoteLink',
                      'callId' => $vote['Call']['id']
                    )
                  );
                }
              } else {
                echo $options[$vote['Vote'][0]['rate']];
              }
            } else { ?>
              <span class="btn_closed">Closed</span>
            <?php 
            } ?>
          </td>
          <td class="td_center last">
            <?php echo $this->Html->link('Share', array('action' => 'profile', $currentUserData['User']['slug'], $vote['Call']['slug'])); ?>
          </td>
        </tr>
      <?php 
      }
    }
  } ?>
</table>
<script type="text/javascript">
$(function(){  
    
    selector = $(".asc, .desc").parent("th");  
    var index = $(selector).index();
    $("table tr").each(function() {
      $(this).children("td:eq("+index+")").addClass("sort_on");
    });
 
});//end jquery ready

</script>
