<?php 
$voteObj = ClassRegistry::init('Vote');
$mostAccurateUsers = $voteObj->mostAccurateUsers();
//debug($mostAccurateUsers);
?>
<div class="title_row">
  <h1 class="accurate">Most Accurate
    <span class="ico_info" title="Ranked by Hit Rate, which is the number of correct predictions divided by the number of total predictions."></span></h1>
</div>
<ol class="user_leaderboard_blocks">
  <?php
    $index = 1;
    $count = count($mostAccurateUsers);
    foreach($mostAccurateUsers as  $key => $user) {
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
    <span><?php echo "$".number_format($user['User']['score'], 2)." Yield"; ?></span>
    <span><?php echo "$".number_format($user[0]['earned'],2) ." Earned"; ?></span>
  </div>
  <div class="board_grade">
    <?php echo number_format($user[0]['hitrate'],0)."%"; ?>
    <span class="accurate_grade"><?php echo "(".$user['User']['calls_correct']."/".$user['User']['calls_graded'].")"; ?></span>
  </div>
  </li>
   <?php } ?>
</ol>