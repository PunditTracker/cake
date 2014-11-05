<div class="title_row title_row2">
  <h1>Prediction's outcome</h1>
  <?php
  if (isset($topPundit['Category']['id'])) {
    echo $this->Html->link(
      "<span id='verticalHistoryLink'>Vertical History</span>",
      array(
        'controller' => 'calls',
        'action'=> 'history',
        $topPundit['Category']['id']
      ),
      array(
        'class' => "btn",
        'escape' => false
      )
    );
  }

  if (isset($punditId)) {
    echo $this->Html->link(
      __('<span id="punditHistoryLink">Pundit History</span>'),
      array(
        'controller' => 'pundits',
        'action' =>  'history',
        $punditId
      ),
      array(
        'class' => 'btn',
        'escape' => false
      )
    );
  }
  ?>
</div><!--end of title_row-->

<?php
if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
  $className = "";
  $tableClass = "table_box admin_table_box";
} else {
  $className = "last";
  $tableClass = "table_box table_box4";
}
?>

<table class="<?php echo $tableClass;?>" id="">
  <thead>
    <tr>
      <th class="col1 tl">Pundit</th>
      <th class="col2 tl">Prediction</th>
      <th class="col4 tl">Date Made</th>
      <th class="col4 tl">Date Due</th>
      <th class="col5"><span>Outcome</span></th>
      <th class="col6 tl">Vote Until</th>
      <th class="col7"><span>Link/Source</span></th>
      <th class="col8 <?php echo $className; ?>"><span>My Vote</span></th>
      <?php
      if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
        echo '<th class="col9 last tl">Action</th>';
      }
      ?>
    </tr>
  </thead>
  <tbody>
  <?php if (count($outcomeData) == 0) : ?>
      <tr>
        <td class="noRecord" colspan='9'>No Records found</td>
      </tr>
    <?php
    else :
      foreach ($outcomeData as $key => $call) {
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
            echo $this->Html->link(
              $call['User']['first_name'].' '.$call['User']['last_name'],
              array(
                'controller' => 'pundits',
                'action' => 'profile',
                $call['User']['id']
              )
            );
            ?>
          </td>
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
              echo $options[$call['Vote'][0]['rate']];
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
              } else {
                echo '<span class="btn_closed">Closed</span>';
              }
            }
            ?>
          </td>
          <?php
          if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
            echo '<td class="last">';
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
            echo '</td>';
          }
          ?>
        </tr>
        <?php
      }
    }
  endif;
  ?>
</table>

