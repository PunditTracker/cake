  <div style="padding-bottom:20px; clear:both; display:block;">
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-2770130917629235";
    /* User Profile: Rotating New */
    google_ad_slot = "8967590946";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
  </div>

<?php if (!$this->request->is('ajax')) {  ?>
<div id="userProfile">
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
    <span>profile</span>
  </div><!--end of breadcrum-->

  <div class="title_row">
      <h1><?php echo $currentUserData['User']['first_name'] . ' ' . $currentUserData['User']['last_name']; ?>: Predictions &amp; Picks </h1>
      <?php
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
      ?>
      <?php
      if ($this->Session->read('Auth.User.id') == $userId) {
        if (!empty($isMobile)) {
          echo $this->Html->link(
            '<span id="UserEditInfo">Edit Info</span>',
            array(
              'controller' => 'users',
              'action' => 'edit_info'
            ),
            array(
              'class' => 'btn shift-left',
              'escape' => false,
              'id' => 'editUserProfileInfoLink-m'
            )
          );

          echo $this->Html->link(
            '<span id="UserChangePassword">Change Password</span>',
            array(
              'controller' => 'users',
              'action'     => 'reset_password'
            ),
            array(
              'class' => 'btn shift-left',
              'escape' => false,
              'id' => 'changeUserPasswordLink-m'
            )
          );
        } else {
          echo $this->Html->link(
            '<span id="UserEditInfo">Edit Info</span>',
            '',
            array(
              'class' => 'btn shift-left',
              'escape' => false,
              'id' => 'editUserProfileInfoLink'
            )
          );

          echo $this->Html->link(
            '<span id="UserChangePassword">Change Password</span>',
            '',
            array(
              'class' => 'btn shift-left',
              'escape' => false,
              'id' => 'changeUserPasswordLink'
            )
          );
        }

      }
      ?>
  </div><!--end of title_row-->


  <div class="cont_row">
     <?php
    $profileOption = array(
      'userInfo'    => $currentUserData,
    );
    //Element for pundit profile info
    echo $this->element('User/user_profile_info', $profileOption); ?>

    <?php
    if ($userId == $this->Session->read('Auth.User.id')) {
      $key = 'element_ranked_user_' . $userId;
      echo $this->element(
        'User/profile_user_ranking',
        array(),
        array(
          'cache' => array(
            'config' => 'user_ranking_element_config',
            'key'    => $key,
          )
        )
      );
    } else {
    ?>
      <div class="sidebar">
        <!--script type="text/javascript"><!--
        google_ad_client = "ca-pub-2770130917629235";
        /* UserProfile */
        google_ad_slot = "2986823907";
        google_ad_width = 300;
        google_ad_height = 250;
        //-->
        <!--/script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script-->
  <div class="pundit_cred">
    <?php
    echo $this->Html->link(
      $this->Html->image(
        'blue_btn.png',
        array('alt' => '', 'width' => '186px', 'height' => '29px')
      ),
      array('controller' => 'categories', 'action' => 'view', 'all'),
      array(
        'escape' => false,
        'class' => 'blue_btn'
      )
    );
    ?>

  <?php echo $this->Html->link($this->Html->image('grey_btn.png', array('alt' => '', 'width' => '91px', 'height' => '29px')), "http://blog.pundittracker.com/how-user-voting-works-aka-how-to-become-a-featured-pundit/", array('escape' => false, 'class' => 'grey_btn')); ?>

    </div>

      </div><!--end of sidebar-->
    <?php } ?>

  </div><!--end of cont_row-->

  <!--div style="padding-bottom:20px; clear:both; display:block;">
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-2770130917629235";
    /* User Profile: Rotating New */
    google_ad_slot = "8967590946";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    <!--/script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
  </div-->

 <!-- 728×90 pundit-leaderboard-ad -->
  <div class = "horizontalAd">
  <div class="pundit-leaderboard">
  <div class="pundit-username"> Can you make better predictions than</br><?php echo $currentUserData['User']['first_name'] . ' ' . $currentUserData['User']['last_name']; ?>? </div>
  <?php echo $this->Html->link(
  $this->Html->image(
  'blue_btn.png',
  array('alt' => '', 'class' => 'leaderbd_btn', 'width' => '186px', 'height' => '29px')),
  array('controller' => 'categories', 'action' => 'view', 'all'), array('escape' => false)); ?>

    <div class="pundit-leaderbd-holder"> <?php echo $this->Html->tag('span',__('OR',true)),$this->Html->link('Learn More', "http://blog.pundittracker.com/how-user-voting-works-aka-how-to-become-a-featured-pundit/", array('class' => 'learnmr_btn')); ?>
         </div>
  </div>
  </div><!--end-->

  <div class="table_holder" id="CallTable">
    <?php } ?>
    <div class="table_row">
      <?php
      /*$paginationOption = array(
        'model' => 'Call',
        'keyId' => $currentUserData['User']['slug'],
        'divId' => 'CallTable'
      );
      echo $this->element('Common/user_profile_tabs', array('userId' => $currentUserData['User']['id']));
      echo $this->element('Common/multi_pagination', $paginationOption); */?>
    </div><!--end of table_row-->
     <div class="table_row">
      <div class="table_btns">
       <h2><a class="on">Live Predictions</a></h2>
      </div>
    </div>
        <?php echo $this->element('User/live_call_table');
            echo $this->Html->link(
            '<span id="allPunditsLink">See All Live Predictions</span>',
            array(
              'controller' => 'users',
              'action' => 'profile_calls', $currentUserData['User']['slug'],
              'admin' => false
            ),
            array(
              'class' => 'btn shift-left',
              'escape' => false
            )
          );
      ?>
     <div class="table_row">
      <div class="table_btns">
        <h2><a class="on">Past Predictions: Track Record</a></h2>
      </div>
    </div>

    <?php echo $this->element('User/archive_call_table'); ?>

    <div class="table_row">
      <?php //echo $this->element('Common/multi_pagination', $paginationOption );
        //if ($this->Session->read('Auth.User')) {
          echo $this->Html->link(
            '<span id="allPunditsLink">See All Past Predictions</span>',
            array(
              'controller' => 'users',
              'action' => 'profile_calls', $currentUserData['User']['slug'],
              'archive' => true,
              'admin' => false
            ),
            array(
              'class' => 'btn shift-left',
              'escape' => false
            )
          );
        //}
       ?>
    <?php if (!$this->request->is('ajax')) {  ?>

  </div><!--end of table_holder-->

</div><!-- user profile -->
<?php } echo $this->Js->writeBuffer(); ?>
