<?php 
$voteObj = ClassRegistry::init('Vote');
$lifeTimeLeader = $voteObj->lifeTimeLeaders();
//debug($mostAccurateUsers);
?>
<div class="block topUser">
  <div class="title_row">
      <h1 class="lifetime">Featured Users</h1>
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
          <span><?php echo "Voted on ".$user[0]['voteon']." predictions"; ?></span>
          
        </div>
        <div class="board_grade">
          <?php echo "$".number_format($user[0]['earned'], 2); ?>
        </div>
      </li>
      <?php }?>
      <li>
        <?php #if($this->params['controller'] != 'pundits') { ?>
        <a id="why_vote"  href="javascript: return false;" class="toprank_btn btn_grey" id="why_vote" title="<?php echo Configure::read('whyShouldVoteToolTipMsg') ?>">Why Should I vote?</a>
        <?php
          echo $this->Html->link(
          '<span>Full Leaderboard</span>',
           array('controller' => 'users', 'action' => 'user_leaderboard'),
            array(
            'escape' => false,
            'class' => 'toprank_btn users_leaderbd'
          )
        );
    ?>
         <!-- <a id="why_vote"  href="javascript: return false;" class="btn" id="why_vote" title="<?php echo Configure::read('whyShouldVoteToolTipMsg') ?>"><span>Full Leaderboard</span></a> -->
      
     <?php #}?>
    </li>
</ol>
</div>
