<?php $optionRadio  = Configure::read('radio_vote_option'); ?>
<div class="breadcrum">
  <?php
  echo $this->Html->link(
    __('home'),
    array(
      'controller' => 'users',
      'action' => 'home',
      'admin' => false
    ),
    array()
  );
  ?> &raquo;
  <span>SEARCH</span>
</div><!--end of breadcrum-->

<div class="title_row">
    <h1>SEARCH RESULT</h1>
</div><!--end of title_row-->

<div class="">  
  <?php if (isset($invalid)) { ?>
    <div class='error-message'><h2>Please enter atleast 3 characters in search box.</h2></div>
  <?php } 

   if (!empty($findRaw)) : ?>
   
    <div class="table_holder">
      <div class="table_row">
        <h2>Pundits matching '<?php echo $findRaw; ?>'</h2>
        <?php 
        if ($totalPunditFound == 0) {
          ?>
          <table class="table_col">
            <tr>
              <th class="th1">Pundits</th>
              <th class="th2">Grade</th>
            </tr>
            <tr>
              <td class="noRecord" colspan='2'>No Records found</td>
            </tr>
          </table>
          <?php          
        } elseif ($totalPunditFound == 1) {
          $table_start = $table_end = array(
            1 => 0                             
          );          
          $table1_I = 0;
        } elseif($totalPunditFound == 2) {
          $table_start = $table_end = array(
            1 => 0,       
            2 => 1                        
          );                   
        } elseif ($totalPunditFound >= 3) {        
          $rows = floor($totalPunditFound/3);
          $extraRow = 0;
          $extraRow = $totalPunditFound%3;
          $table_start = array(
            1 => 0,       
            2 => $rows,          
            3 => 2*$rows               
          ); 
          $table_end = array(            
            1 => $rows -1,            
            2 => $rows + ($rows -1),            
            3 => (2*$rows) + ($rows -1) + $extraRow,
          );      
        }
             

        if (1 <= $totalPunditFound) {
          for ($flag = 1; $flag <= count($table_start); $flag++) {
            $class = ($flag == 3) ? "last_table_col" : null;
           
            ?>
          <table class="table_col <?php echo $class;?>">
            <tr>
              <th class="th1">Pundits</th>
              <th class="th2">Grade</th>
            </tr>        
            <?php 
            
              for ($row = $table_start[$flag]; $row <= $table_end[$flag]; $row++) {
            ?>
            <tr class="">      
              <td class="td1">
                <?php echo $this->Html->link($userData[$row]['User']['first_name']. ' ' .$userData[$row]['User']['last_name'], array('controller' => 'pundits', 'action' => 'profile', $userData[$row]['User']['id']), array()); ?>                               
              </td>
              <td><?php echo $this->PT->getGrade($userData[$row]['Pundit']['score'], $userData[$row]['Pundit']['calls_graded']); ?></td>
            </tr>
          <?php  }  ?>     
          </table>
          <?php

          }
        }
        ?>     
      </div>
    </div>

    <div class="table_holder">
      <div class="table_row">
        <h2>Predictions  matching '<?php echo $findRaw; ?>'</h2>
        <?php $paginationOption = array('model' => 'Call', 'action' => 'search');     
          echo $this->element('Common/multi_pagination', $paginationOption); 
        ?>
      </div>
        <table class="table_box" id="tableToSort">
        <tr>
          <th class="col1"><?php echo $this->Paginator->sort('User.first_name', 'Pundit', array('class' => 'sort_down'));?></th>
          <th class="col2"><?php echo $this->Paginator->sort('Call.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
          <th class="col6"><?php echo $this->Paginator->sort('Call.created', 'Date Made', array('class' => 'sort_down'));?></th>
          <th class="col4"><?php echo $this->Paginator->sort('Call.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
          <th class="col3"><span>Outcome</span></th>
          <th class="col6"><?php echo $this->Paginator->sort('Call.vote_end_date', 'Vote Until', array('class' => 'sort_down'));?></th>
          <th class="col7"><span>Link/Source</span></th>
          <th class="col8 last"><span>My Vote</span></th>
        </tr>
        <?php

        if (empty($calls)) {
        ?>
          <tr>
            <td class="noRecord" colspan='9'>No Records found</td>
          </tr>
        <?php
        } else {
          foreach ($calls as $key => $call) {
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
                <td>
                  <?php
                  if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
                    echo $this->Html->link(
                      __('edit'),
                      array(
                        'admin' => true,
                        'controller' => 'calls',
                        'action' => 'edit',
                        $call['Call']['id']
                      ),
                      array(
                        'class' => 'row_link',
                        'id' => 'editCallSuggestionId'
                      )
                    );
                  }
                  echo $this->Html->link(
                    $call['User']['first_name'].' '.$call['User']['last_name'],
                    array(
                      'controller' => 'pundits',
                      'action' => 'profile',
                      $call['User']['id']),
                      array()
                  );
                  ?>
                </td>
                <td class="preFirst"><?php echo $call['Call']['prediction']; ?></td>
                <td class="td_center"><?php echo $this->PT->dateFormat($call['Call']['created']); ?></td>
                <td class="td_center"><?php echo $this->PT->dateFormat($call['Call']['due_date']); ?></td>
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
                <td class="td_center last">
                  <?php                
                    if (isset($call['Vote']['rate'])) {

                      if ($call['Call']['vote_end_date'] >= date('Y-m-d')) {
                        echo $this->Html->link(
                          $optionRadio[$call['Vote']['rate']],
                          '',
                          array(
                            'id' => 'call'.$call['Call']['id'],
                            'class' => 'editVoteLink',
                            'callId' => $call['Call']['id']
                          )
                        );
                      } else {
                        echo '<span class="no_btn">' . @$optionRadio[$call['Vote']['rate']] . '</span>';
                      }
                    } else {
                      if ($call['Call']['vote_end_date'] >= date('Y-m-d')) {
                        echo $this->Html->link(
                          __('Vote Now'),
                          '',
                          array(
                            'id' => 'call'.$call['Call']['id'],
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
              </tr>
            <?php
            }
          }
        } ?>
      </table>
      <div class="table_row">       
        <?php $paginationOption = array('model' => 'Call', 'action' => 'search');     
          echo $this->element('Common/multi_pagination', $paginationOption); 
        ?>
      </div>    
    </div>
  <?php endif; ?> 
</div><!--end of main_content-->


<?php  echo $this->Js->writeBuffer(); //echo $this->element('Common/static_side_bar'); ?>

