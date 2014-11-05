<?php 
$optionsRadio = Configure::read('radio_vote_option'); ?>
<div class="table_row">
	<h1 id='punditHistory'><?php echo __("%s History",$userInfo['User']['first_name'].' '.$userInfo['User']['last_name']); ?></h1>
	<?php 
  $paginationOptions = array('model' => 'Call', 'keyId' => $punditId, 'action' => 'history');
  echo $this->element('Common/multi_pagination', $paginationOptions); ?> 
</div><!--end of title_row-->
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
<table class="<?php echo $tableClass;?>" id="">
  <tr>
    <th class="col2"><?php echo $this->Paginator->sort('Call.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
    <th class="col4"><?php echo $this->Paginator->sort('Call.created', 'Date Made', array('class' => 'sort_down'));?></th>
    <th class="col4"><?php echo $this->Paginator->sort('Call.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
    <th class="col5"><span>Outcome</span></th>
    <th class="col6"><?php echo $this->Paginator->sort('Call.vote_end_date', 'Vote Until', array('class' => 'sort_down')); ?></th>
    <th class="col7"><span>Link/Source</span></th>
    <th class="col8 <?php echo $className; ?>"><span>My Vote</span></th>
    <?php
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') { ?>
      <th class="col9 last tl">Action</th>
    <?php 
    } ?>
  </tr>
  <?php 
  if (count($punditHistory) == 0) { ?>
    <tr>
      <td class="noRecord" colspan='8'>No Records found</td>
    </tr>
  <?php
  } else {
    foreach ($punditHistory as $key => $call) { 
      if (count($call) > 0) {
        $outcome = 'TBD';
        if (isset($call['Call']['outcome_id']) && !empty($call['Call']['outcome_id'])) {
          switch ($call['Call']['outcome_id']) {
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
          <td><?php echo $call['Call']['prediction']; ?></td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($call['Call']['created']); ?>
          </td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($call['Call']['due_date']); ?>
          </td>
          <td class="td_center"><?php echo $outcome; ?></td>
          <td class="td_center">
            <?php
            if ($call['Call']['vote_end_date'] >= date('Y-m-d')) { 
              echo $this->PT->dateFormat($call['Call']['vote_end_date']);
            } else { ?>
              <span class="">Closed</span>
            <?php 
            }           
            ?>
          </td>
          <td class="td_center"><?php echo $call['Call']['source']; ?></td>
          <td class="td_center <?php echo $className; ?>">
            <?php           
              if (isset($call['Vote'][0]['rate'])) { 
               echo $optionsRadio[$call['Vote'][0]['rate']];
              } else { 
                if ($call['Call']['vote_end_date'] >= date('Y-m-d') && empty($call['Call']['outcome_id'])) {
                  echo $this->Html->link(
                    __('Vote Now'), 
                    '', 
                    array(
                      'class' => 'btn_vote_now', 
                      'callId' => $call['Call']['id']
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
                  $call['Call']['id']
                ),
                array(
                  'class' => 'btn_edit editCallSuggestion',
                  'id' => 'editCallSuggestionId'
                )
              );
              ?>
            </td>
          <?php
          } ?>
        </tr>
      <?php 
      }
    }//end foreach
  }
  ?>
</table>
<div class="table_row">     
  <?php echo $this->element('Common/multi_pagination', $paginationOptions); ?> 
  <?php echo $this->Js->writeBuffer(); ?>            
</div><!--end of table_row-->

<script type="text/javascript">
  $(function(){  
      
      selector = $(".asc, .desc").parent("th");  
      var index = $(selector).index();
      $("table tr").each(function() {
        $(this).children("td:eq("+index+")").addClass("sort_on");
      });
   
  });//end jquery ready
</script>