<div class="block topUser sidebar">
  <div class="title_row2">
      <h1>User Ranking</h1>
  </div>
    <?php if (!empty($ranking['rank']) && ('N/A' != $ranking['rank'])) { ?>
      <div class="title_row2 user_ranking_title">
        <span class="big-font">
          <?php 
            if ($userId == $this->Session->read('Auth.User.id')) {
              echo "You're ranked #". $ranking['rank'];
            } else {
              echo $currentUserData['User']['first_name']. " ranked #". $ranking['rank'];
            }
            
          ?>
        </span>&nbsp;
        <span class="small-font"> <?php echo 'out of '. $ranking['totalUser'] . ' users.';?></span>
      </div>
    <?php } else {?>
      <div class="title_row2 user_ranking_title show-tooltip" title="<?php echo Configure::read('youAreNotRankedToolTipMsg'); ?>">
        <span class="big-font">
          <?php 
            if ($userId == $this->Session->read('Auth.User.id')) {
              echo "You're not ranked";
            } else {
              echo $currentUserData['User']['first_name']. " not ranked";
            }
            
          ?>
        </span>&nbsp;
        <span class="small-font"> Learn Why</span>
      </div>
    <?php } ?>

  <ol class="featured_pundits_list profile_user_rankings">
    <?php 
    $topRankedUsers = ClassRegistry::init('Vote')->getTopUser();
    $index = 1;
    foreach($topRankedUsers as  $user) { 
    ?>
    <li>
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
        <span>
          <?php
            $score = (null != $user['User']['score']) ? $user['User']['score'] : 0;
            echo '$'.$score . 'Yield'; 

            echo ', '. $this->PT->hitRate($user['User']['calls_correct'], $user['User']['calls_graded']).'% Hit Rate ('.$user['User']['calls_correct'] . '/'. $user['User']['calls_graded'] . ' Correct)' ;
          ?>
        </span>
      </div>
    </li>
    <?php } ?>         
  </ol>
  <div class="improve-your-ranking">
    <?php 
      echo $this->Html->link(
                            'See Full User Leaderboard >>',
                              array(
                                'controller' => 'users', 
                                'action' => 'user_leaderboard'
                              )
                            );
    ?>
  </div>
</div>      
