<div class="vote_col">
  <div class="vote_box1">
    <div class="vote_title"><span>arrow</span><?php echo $call['Call']['prediction'] ?></div>
    <ul class="vote_info_list">
      <li>
        <span>Pundit</span>
        <strong>
          <?php
          echo $this->Html->link(
            $call['User']['first_name'] . ' ' . $call['User']['last_name'],
            array(
              'controller' => 'pundits',
              'action' => 'profile',
              'admin' => false,
              $call['User']['slug']
            ),
            array()
          ); ?>
          <em class="<?php echo  $category[$call['Category']['name']]; ?>"></em>
        </strong>
      </li>
      <li>
        <span>Source</span>
        <strong><?php echo $call['Call']['source']; ?></strong>
      </li>
      <li>
        <span>Prediction Date</span>
        <strong><?php echo $this->PT->dateFormat($call['Call']['created']); ?></strong>
      </li>      
    </ul> 
    <div class="vote_for_box">
      <div class="vote_close_in">Voting Closes in: <span> <?php echo $this->PT->dateDiff($call['Call']['vote_end_date']); ?></span></div>
      <?php
      $formOptions = array(
        'id'  => 'VoteAddForm' . $call['Call']['id'],
        'url' => array(
          'controller' => 'votes',
          'action'     => 'add',
          $call['Call']['id']
        )
      );
      echo $this->Form->create('Vote', $formOptions);
      ?>
        <div class="vote_for_title "><?php echo $call['Call']['prediction'] ?></div>
        
        <ul class="vote_choices">
          <?php
          foreach ($options as $key => $option) { ?>
          <li>
              <?php
              echo $this->Form->unlockField('Vote.rate][' . $call['Call']['id']);
              echo $this->Form->unlockField('Vote.rate');
              $selected = '';
              if (isset($call['Vote'][0]['rate'])) {
                if ($call['Vote'][0]['rate'] == $key) {
                  $selected = 'checked';
                }
              }

              echo $this->Form->radio(
                'rate][' . $call['Call']['id'],
                array(
                  $key => $option
                ),
                array(
                  'hiddenField' => false,
                  'checked' => $selected
                )
              );
              ?>
          </li>
          <?php
          }  ?>
          <div id="errorMessage" class="voteErrorMsg">        
          <?php if (!empty($rateError)) echo $rateError; ?>   
          </div>       
        </ul>
        <?php echo $this->Form->hidden('call_id', array('value' => $call['Call']['id'])); ?>
        <?php
        //if (!isset($call['Vote'][0]['rate'])) {
          echo $this->Form->button(
            'Vote Now',
            array(
              'type' => 'submit',
              'class' => 'input_vote_now',
              'id' => 'addNewVoteButton',
              'callId' => $call['Call']['id']
            )
          );
        /*} else { ?>
          <span class="btn_closed">Voted</span>
        <?php
        } ?>
        <span class="btn_closed hide" id="showClosedButton<?php echo $call['Call']['id']; ?>">Voted</span>
      <?php */
      echo $this->Form->end();
      ?>
    </div>
  </div>
</div><!--end of vote_col-->
