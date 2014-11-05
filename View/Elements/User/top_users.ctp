<div class="title_row">
    <h1 class="topranked">Top-Ranked
    <span class="ico_info" title="Ranked by $1 Yield, which is the average return had you placed $1 bets on each of the user’s predictions. This is PunditTracker’s core scoring metric and translates into our Letter Grade"></span></h1>
</div>
<?php 
$voteObj = ClassRegistry::init('Vote');
$topUsers = $voteObj->topUsers();
//debug($topUsers);
?>
<ol class="user_leaderboard_blocks">
    <?php
    $index = 1;
    $count = count($topUsers);
    foreach($topUsers as  $key => $user) {
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
        <span><?php echo "".number_format($user[0]['hitrate'],0)."% Hit Rate (".$user['User']['calls_correct']."/".$user['User']['calls_graded'].")"; ?></span>
        <span><?php echo "$".number_format($user[0]['earned'],2) ." Earned"; ?></span>
      </div>
      <div class="board_grade">
        <?php echo "$".number_format($user['User']['score'], 2); ?>
      </div>
    </li>
    <?php } ?>
   
</ol>