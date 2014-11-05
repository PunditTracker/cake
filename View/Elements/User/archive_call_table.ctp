<?php $options = Configure::read('radio_vote_option');
?>
<table class="table_box table_box4" id='userProfileArchieveTable'>
  <tr>
    <?php if(isset($live_archive_call)) { ?>
      <th class="col1"><span>Pundit</span></th>
      <th class="col2"><span>Prediction</span></th>
      <th class="col5"><span>Outcome</span></th> 
      <th class="col5"><span>Date Made</span></th>
      <th class="col5"><span>Date Due</span></th>
      <th class="col5"><span>Vote Date</span></th>
      <th class="col5"><span>Vote Until</span></th>
      <th class="col5"><span>My Vote</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col5"><span>My Outcome</span></th>
      <th class="last col7"><span>Share</span></th>
    <?php } else {?>
      <th class="col1"><?php echo $this->Paginator->sort('User.first_name', 'Pundit', array('class' => 'sort_down'));?></th>
      <th class="col2"><?php echo $this->Paginator->sort('CallDummy.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
      <th class="col5"><span>Outcome</span></th>    
      <th class="col5"><?php echo $this->Paginator->sort('CallDummy.created', 'Date Made', array('class' => 'sort_down'));?></th>
      <th class="col5"><?php echo $this->Paginator->sort('CallDummy.due_date', 'Date Due', array('class' => 'sort_down'));?></th>    
      <th class="col5"><?php echo $this->Paginator->sort('Vote.created', 'Vote Date', array('class' => 'sort_down'));?></th>
      <th class="col5"><?php echo $this->Paginator->sort('CallDummy.vote_end_date', 'Vote Until', array('class' => 'sort_down'));?></th>
      <th class="col5"><span>My Vote</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col5"><span>My Outcome</span></th>
      <th class="last col7"><span>Share</span></th>
    <?php } ?>
  </tr>
  <?php 
  if (count($userProfileArchiveData) == 0) {
  ?>
    <tr>
    <td class="noRecord" colspan='11'>No Records found</td>
    </tr>
  <?php
  } else {
    foreach ($userProfileArchiveData as $key => $vote) { 
      if (count($vote['CallDummy']) > 0) {
        $outcome = 'TBD';
        if (isset($vote['CallDummy']['outcome_id']) && !empty($vote['CallDummy']['outcome_id'])) {
          switch ($vote['CallDummy']['outcome_id']) {
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
          <td class="preFirst"><?php echo $vote['CallDummy']['prediction']; ?></td>
          <td class="td_center">
            <?php echo $outcome; ?>
          </td>          
          <td class="td_center">
            <?php echo $this->PT->dateFormat($vote['CallDummy']['created']); ?>
          </td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($vote['CallDummy']['due_date']); ?>
          </td>         
          <td class="td_center">
            <?php echo $this->PT->dateFormat($vote['Vote'][0]['created']); ?>
          </td>
          <td class="td_center">
            <?php
            if ($vote['CallDummy']['vote_end_date'] >= date('Y-m-d')) { 
              echo $this->PT->dateFormat($vote['CallDummy']['vote_end_date']);
            } else { ?>
              <span class="">Closed</span>
            <?php 
            }           
            ?> 
          </td>
          <td class="td_center">
            <?php 
            if (isset($vote['Vote'][0]['rate'])) { 
             echo @$options[$vote['Vote'][0]['rate']];
            } else { ?>
              <span class="btn_closed">Closed</span>
            <?php 
            } ?>
          </td>
          <td class="td_center">
            <?php if($this->PT->callBoldness($vote['Vote'][0]['boldness'], false) == "TBD" ) {
                    echo $this->Html->image('tbd.png', array('alt' => 'TBD'));;
                  }else {
                    echo $this->PT->callBoldness($vote['Vote'][0]['boldness'], false);
                  }?>
          </td>
          <td class="td_center">
            <?php echo $this->Html->image($this->PT->myOutcome($vote['Outcome']['rating'], $vote['Vote'][0]['rate'])); ?>
          </td>
          <td class="td_center last">
            <?php echo $this->Html->link('Share', array('action' => 'profile', $currentUserData['User']['slug'], $vote['CallDummy']['slug'])); ?>
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