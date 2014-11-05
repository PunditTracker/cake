  <!-- 728×90 ad -->
  <div class = "horizontalAd">
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-2770130917629235";
    /* Pundit */
    google_ad_slot = "6859877066";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
  </div>

<?php if (!$this->request->is('ajax')) {  ?>
<div id="punditProfile">
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
    <span>Pundit profile</span>
  </div><!--end of breadcrum-->

  <div class="title_row">
    <h1><?php echo $userInfo['User']['first_name'] . ' ' . $userInfo['User']['last_name']; ?>:  <?php if ($msg != '') {
      echo "Picks &amp; Predictions";
    } else {
      echo "Predictions &amp; Picks ";
    }
    ?> </h1>
    <?php
    if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      $callSuggestionId = 'suggestCallBoxByAdmin';
    } else {
      $callSuggestionId = 'suggestCallBox';
    }

    if (empty($isMobile)) {
      if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
        $callSuggestionId = 'suggestCallBoxByAdmin';
      } else {
        $callSuggestionId = 'suggestCallBox';
      }
      echo $this->Html->link(
        '<span>help us track</span>',
        '',
        array(
          'class' => 'btn',
          'escape' => false,
          'id' => $callSuggestionId
        )
      );
    } else {
      $pageUrl = array(
        'controller' => 'users',
        'action'     => 'login',
      );
      if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
        $pageUrl = array(
          'controller' => 'calls',
          'action'     => 'add',
          'admin'      => true,
        );
      } elseif ($this->Session->read('Auth.User.id')) {
        $pageUrl = array(
          'controller' => 'calls',
          'action'     => 'add',
          'admin'      => false,
        );
      }
      echo $this->Html->link(
        '<span>help us track</span>',
        $pageUrl,
        array(
          'class' => 'btn',
          'escape' => false,
        )
      );

    }
    if (($this->Session->read('Auth.User.userGroup') == 'Admin') || ($this->Session->read('Auth.User.userGroup') == 'Pundit' && ($userInfo['Pundit']['user_id']) == $this->Session->read('Auth.User.id'))) {
      echo $this->Html->link(
        '<span id="PunditEditInfo">Edit Pundit Info</span>',
        array('controller' => 'pundits', 'action' => 'edit_info', $userInfo['User']['id'], 'admin' => true),
        array(
          'class' => 'btn shift-left',
          'escape' => false,
          'id' => 'editPunditProfileInfoLink',
          'mobile' => $isMobile
        )
      );
    }
    ?>
  </div><!--end of title_row-->

   <div class="cont_row">
    <?php
    $profileOption = array(
      'userInfo'    => $userInfo,
    );
    //Element for pundit profile info
    echo $this->element('Pundit/pundit_profile_info', $profileOption); ?>
    <!-- element for blog post -->
    <?php
    echo $this->element('Pundit/pundit_blog_post',
      array(
        'position' => 'side_block',
        'punditName' => $userInfo['User']['first_name'].' '.$userInfo['User']['last_name']
      ),
      array(
        'cache' => array(
          'config' => 'element_config',
          'key' => $userInfo['User']['first_name'].' '.$userInfo['User']['last_name'],
          //'time' => '+1 hour'
        )
      )
    );?>

  </div><!--end of cont_row-->

  <?php
  #<script type="text/javascript"><!-- google_ad_client = "ca-pub-2770130917629235"; /* UserProfile: Rotating */ google_ad_slot = "5244008941"; google_ad_width = 728; google_ad_height = 90; //--> </script> <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>
  ?>
  <!-- 728×90 pundit-leaderboard-ad -->
  <div class = "horizontalAd">
   <div class="pundit-leaderboard">
    <div class="pundit-username"> 
      Can you make better predictions than</br><?php echo $userInfo['User']['first_name'].' '.$userInfo['User']['last_name']?>? 
    </div>
    <?php echo $this->Html->link(
      $this->Html->image(
      'blue_btn.png',
      array('alt' => '', 'class' => 'leaderbd_btn', 'width' => '186px', 'height' => '29px')),
      array('controller' => 'categories', 'action' => 'view', 'all'), array('escape' => false)); 
    ?>
    <div class="pundit-leaderbd-holder">
      <?php echo $this->Html->tag('span',__('OR',true)),$this->Html->link('Learn More', "http://blog.pundittracker.com/how-user-voting-works-aka-how-to-become-a-featured-pundit/", array('class' => 'learnmr_btn')); ?>
    </div>
  </div>
  
</div><!--end-->


  <div class="voteToolTip">
    <a href="javascript: return false;" class="btn" id="why_vote" title="<?php echo Configure::read('whyShouldVoteToolTipMsg') ?>"><span>why should i vote?</span></a>
  </div>
  <br style="clear:both;" />
  <div class="table_holder" id="CallTable">
    <?php } ?>
    <div class="table_row">
    <?php
      $optionsRadio = Configure::read('radio_vote_option');
      $options = Configure::read('options'); ?>
      <?php
      $paginationOption = array(
        'model' => 'Call',
        'keyId' => $userInfo['User']['slug'],
        'action' => 'live',
        'divId'  => 'CallTable'
      );
      echo $this->element('Common/pundit_profile_tabs');
      echo $this->element('Common/multi_pagination', $paginationOption); ?>
    </div><!--end of table_row-->

    <?php echo $this->element('Pundit/live_call_table', array(
                'liveData' => $userProfileLiveData,
                'options' => $optionsRadio)
                );  ?>
    <div class="table_row">
    <?php echo $this->element('Common/multi_pagination', $paginationOption);?>

    </div><!--end of table_row-->

    <?php if (!$this->request->is('ajax')) {  ?>
  </div><!--end of table_holder-->

</div><!-- End #punditProfile -->

<div class="blocks_holder">
  <?php echo $this->element('User/home_top_pundit', array('topPundit' => $topPundit));?>
  <div style="float:left;margin-left:20px;">
    <?php echo $this->element('User/featured_user', array('topPundit' => $topPundit));?>
  </div>
  <div style="float:right;margin-right:4px;">
    <script type="text/javascript"><!--
      google_ad_client = "ca-pub-2770130917629235";
      /* Pundit */
      google_ad_slot = "4740364140";
      google_ad_width = 300;
      google_ad_height = 250;
      //-->
    </script>
    <script type="text/javascript"
      src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
  </div>
</div>

<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<fb:comments colorscheme="light" href="<?php echo 'http://'.$this->request->domain(2).'/pundits/profile/'.$userInfo['User']['slug'];?>" num_posts="5"
  width="970px"></fb:comments>
<?php } echo $this->Js->writeBuffer(); ?>
