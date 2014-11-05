<?php 
$voteObj = ClassRegistry::init('Vote');
$lifeTimeLeader = $voteObj->lifeTimeLeaders();
//debug($mostAccurateUsers);
?>
<div class="block">
  <div class="title_row">
      <h1 class="lifetime">Lifetime learders</h1>
  </div>
  <ol class="user_leaderboard_blocks">
    <?php
      $index = 1;
      $count = count($lifeTimeLeader);
      foreach($lifeTimeLeader as  $key => $user) {
        if ($key + 1 == $count) {
          $lastItem = true;
        }
    ?>
    <li <?php if (!empty($lastItem)) echo 'class="last-top-user"' ?>>
      <div class="board_order" id="user<?php echo $index; ?>"><?php echo $index++; ?></div>
        <div class="board_img">
          <?php
            $imgPath = $this->PT->setImage($user['User']['avatar'], $user['User']['fb_id']);
            echo $this->Html->image($imgPath, array('alt' => '', 'class' => 'img4040'));
          ?>
        </div>
        <div class="board_txt">
          <?php
            echo $this->Html->link(
              $user['User']['first_name']. ' ' .$user['User']['last_name'],
              array(
                'controller' => 'users',
                'action'=> 'profile',
                $user['User']['id']
              )
            );

          ?>
          <span><?php echo "$".number_format($user[0]['yield'], 2)." Yield"; ?></span>
          <span><?php echo "".number_format($user[0]['hitrate'],0)."% Hit Rate (".$user['User']['calls_graded']."/".$user['User']['calls_correct'].")"; ?></span>
        </div>
        <div class="board_grade">
          <?php echo "$".number_format(round($user[0]['earned']), 1); ?>
        </div>
      </li>
      <?php }?>
  </ol>
</div> <!-- Third Block End -->