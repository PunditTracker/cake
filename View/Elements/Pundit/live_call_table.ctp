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
      <th class="col6"><span>Vote Until</span></th>
      <th class="col7"><span>Link/Source</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col8 <?php echo $className; ?> last"><span>My Vote</span></th>
    <?php } else {?>
      <th class="col2"><?php echo $this->Paginator->sort('Call.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
      <th class="col4"><?php echo $this->Paginator->sort('Call.created', 'Date Made', array('class' => 'sort_down'));?></th>
      <th class="col4"><?php echo $this->Paginator->sort('Call.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
      <th class="col6"><?php echo $this->Paginator->sort('Call.vote_end_date', 'Vote Until', array('class' => 'sort_down'));?></th>
      <th class="col7"><span>Link/Source</span></th>
      <th class="col5"><span>Boldness</span></th>
      <th class="col8 <?php echo $className; ?>"><span>My Vote</span></th>  
    <?php } ?>
    
    <?php
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') { ?>
      <th class="col9 last tl">Action</th>
    <?php 
    } ?>
  </tr>
  <?php 
  if (count($liveData) == 0) {
  ?>
    <tr>
      <td class="noRecord" colspan='8'>No Records found</td>
    </tr>
  <?php
  } else {
    foreach ($liveData as $key => $call) { 
      if (count($call) > 0) {
        $class = '';
        if (($key % 2) == 0) {
          $class = 'odd';
        } 
        ?>
        <tr class="<?php echo $class; ?>">
          <td class="preFirst"><?php echo $call['Call']['prediction']; ?></td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($call['Call']['created']); ?>
          </td>
          <td class="td_center">
              <?php echo $this->PT->dateFormat($call['Call']['due_date']); ?>
          </td>          
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
          <td class="td_center"><?php if($this->PT->callBoldness($call['Call']['boldness'], true) === "TBD") {
              echo $this->Html->image('tbd.png', array('alt' => 'tbd'));
          } else {
            echo $this->PT->callBoldness($call['Call']['boldness'], true);
          } ?></td>
          <td class="td_center <?php echo $className; ?>">
            <?php
            if (isset($call['Vote']['rate']) && (!empty($call['Vote']['rate']) || ($call['Vote']['rate'] == 0))) { 
              if ($call['Call']['vote_end_date'] >= date('Y-m-d')) {
                if (!empty($isMobile)) {
                  $pageUrl = array(
                    'controller' => 'users',
                    'action'     => 'login',
                    'admin'      => false,
                  );
                  if ($this->Session->read('Auth.User.id')) {
                    $pageUrl = array(
                      'controller' => 'votes',
                      'action'     => 'add',
                      'admin' => false,
                      $call['Call']['id'],
                    );
                  }
                  
                  echo $this->Html->link(
                    $options[$call['Vote']['rate']],
                    $pageUrl,
                    array(
                      'id' => 'call'.$call['Call']['id'],
                      //'class' => 'editVoteLink',
                    )
                  );
                } else { 
                  echo $this->Html->link(
                    $options[$call['Vote']['rate']], 
                    "", 
                    array(
                      "class" => "editVoteLink", 
                      "id" => "call".$call["Vote"]["call_id"], 
                      "callId" => $call["Vote"]["call_id"]
                    )
                  );
                }
              } else {
                echo $options[$call['Vote']['rate']];
              }              
            } else { 
              if ($call['Call']['vote_end_date'] >= date('Y-m-d') && empty($call['Call']['outcome_id'])) {
                if (!empty($isMobile)) {
                  $pageUrl = array(
                    'controller' => 'users',
                    'action'     => 'login',
                    'admin'      => false,
                  );
                  if ($this->Session->read('Auth.User.id')) {
                    $pageUrl = array(
                      'controller' => 'votes',
                      'action'     => 'add',
                      'admin' => false,
                      $call['Call']['id'],
                    );
                  }
                    
                  echo $this->Html->link(
                    __('Vote Now'),
                    $pageUrl,
                    array(
                      'id' => 'call'.$call['Call']['id'],
                      'class' => 'btn_vote_now_m',
                    )
                  );
                } else {
                  echo $this->Html->link(
                    __('Vote Now'), 
                    '', 
                    array(
                      'id' => 'call'.$call['Call']['id'],
                      'class' => 'btn_vote_now', 
                      'callId' => $call['Call']['id']
                    )
                  );             
                }
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
