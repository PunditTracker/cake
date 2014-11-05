<div class="block topUser">
  <div class="title_row">
      <h1>Top-Ranked Users</h1>
  </div>

  <ol class="featured_pundits_list">
    <?php
    $index = 1;
    $count = count($topUser);
    foreach($topUser as  $key => $user) {
      if ($key + 1 == $count) {
        $lastItem = true;
      }
    ?>
    <li <?php if (!empty($lastItem)) echo 'class="last-top-user"' ?>>
      <div class="fea_order" id="user<?php echo $index; ?>"><?php echo $index++; ?></div>
      <div class="fea_img">
        <?php
        $imgPath = $this->PT->setImage($user['User']['avatar'], $user['User']['fb_id']);
        echo $this->Html->image($imgPath, array('alt' => '', 'class' => 'img4040'));
        ?>
      </div>
      <div class="fea_txt">
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
	<span>Voted on <?php echo $user[0]['userVote']; ?> predictions</span>
        <!--<span><?php //echo ucwords(strtolower($topPundit['Category']['name'])); ?></span>-->
      </div>
      <div class="fea_grade user_pundit_grade">
        <?php echo $this->PT->getGrade($user['User']['score'], $user['User']['calls_graded']); ?>
      </div>
    </li>
    <?php } ?>
  </ol>
<a id="why_vote" href="javascript: return false;" class="btn_large" id="why_vote" title="<?php echo Configure::read('whyShouldVoteToolTipMsg') ?>">Why Should I vote?</a>
</div>
