<?php
//if logged in as admin
if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
  $className = "";
  $tableClass = "table_box admin_table_box";
} else {
  //logged in as general user
  $className = "last";
  $tableClass = "table_box table_box4";
} ?>
<table class="<?php echo $tableClass;?>" id="tableSorting">
  <tr>
    <?php if(isset($live_archive_call)) { ?>
      <th class="col2"><span>Prediction</span></th>
      <th class="col4"><span>Date Made</span></th>
      <th class="col4"><span>Date Due</span></th>
      <th class="col5"><span>Outcome</span></th>    
      <th class="col7"><span>Link/Source</span></th>
      <th class="col6"><span>Boldness</span></th>
      <th class="col8 <?php echo $className; ?>"><span>My Vote</span></th>
   <?php } else {?>
      <th class="col2"><?php echo $this->Paginator->sort('CallDummy.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
      <th class="col4"><?php echo $this->Paginator->sort('CallDummy.created', 'Date Made', array('class' => 'sort_down'));?></th>
      <th class="col4"><?php echo $this->Paginator->sort('CallDummy.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
      <th class="col5"><span>Outcome</span></th>    
      <th class="col7"><span>Link/Source</span></th>
      <th class="col6"><span>Boldness</span></th>
      <th class="col8 <?php echo $className; ?>"><span>My Vote</span></th>    
    <?php } ?>
    
    <?php
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') { ?>
      <th class="col9 last tl">Action</th>
    <?php 
    } ?>
  </tr>
  <?php 
  if (count($archievesData) == 0) {
  ?>
    <tr>
      <td class="noRecord" colspan='8'>No Records found</td>
    </tr>
  <?php
  } else {
    foreach ($archievesData as $key => $call) { 
      if (count($call) > 0) {
        $outcome = 'TBD';
        if (isset($call['CallDummy']['outcome_id']) && !empty($call['CallDummy']['outcome_id'])) {
          switch ($call['CallDummy']['outcome_id']) {
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
          <td class="preFirst"><?php echo $call['CallDummy']['prediction']; ?></td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($call['CallDummy']['created']); ?>
          </td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($call['CallDummy']['due_date']); ?>
          </td>
          <td class="td_center"><?php echo $outcome; ?></td>         
          <td class="td_center"><?php echo $call['CallDummy']['source']; ?></td>
          <td class="td_center">
            <?php echo $this->PT->callBoldness($call['CallDummy']['boldness'], false);?>
          </td>
          <td class="td_center <?php echo $className; ?>">
            <?php
            if (isset($call['Vote'][0]['rate'])) { 
              echo $options[$call['Vote'][0]['rate']];
            } else { 
              if ($call['CallDummy']['vote_end_date'] >= date('Y-m-d') && $call['CallDummy']['outcome_id'] == '') {
                echo $this->Html->link(
                  __('Vote Now'), 
                  '', 
                  array(
                    'id' => 'call'.$call['CallDummy']['id'],
                    'class' => 'btn_vote_now', 
                    'callId' => $call['CallDummy']['id']
                  )
                );             
              } else { ?>
                <span class="btn_closed">Closed</span>
            <?php 
              }
            } ?>
          </td>          
          <?php
          if ($this->Session->read('Auth.User.userGroup') == 'Admin') { ?>
            <td class="last">
            <?php          
            echo $this->Html->link(
              __('edit'),
              array(
                'admin' => true,
                'controller' => 'calls',
                'action' => 'edit',
                $call['CallDummy']['id']
              ),
              array(
                'class'  => 'btn_edit editCallSuggestion',
                'id'     => 'editCallSuggestionId',
                'mobile' => $isMobile
              )
            );
            ?>
            </td>
          <?php
          } ?>
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
    $("table#tableSorting tr").each(function() {
      $(this).children("td:eq("+index+")").addClass("sort_on");
    });
 
});//end jquery ready

</script>
