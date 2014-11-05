<div class="<?php echo $boxClass; ?>">
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
          );
          ?>
          <em class="<?php echo $category[$call['Category']['name']]; ?>"></em>
      </strong>
    </li>
    <li>
        <span>Source</span>
        <strong><?php echo $call['Call']['source']; ?></strong>
    </li>
    <li>
        <span>Prediction Date</span>
        <strong><?php echo $this->PT->dateFormat($call['Call']['created']);?></strong>
    </li>
  </ul>
  <div class="vote_outcome_box">
    <strong>Outcome</strong>
    <?php
    switch ($call['Call']['outcome_id']) {
      case 4:
      case 5:
        echo '<span class="outcome_yes">yes</span>';
        break;
      case 1:
      case 2:
      case 3:
        echo '<span class="outcome_no">no</span>';
        break;
      default:
        echo '<span class="outcome_tbd">TBD</span>';
    }
    ?>
  </div>
</div>
