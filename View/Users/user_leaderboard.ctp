<div style="padding-bottom:20px; clear:both; display:block;">
  <script type="text/javascript"><!-- 
  google_ad_client = "ca-pub-2770130917629235"; 
  /* User Leaderboard Top */ 
  google_ad_slot = "8334899343"; 
  google_ad_width = 728; 
  google_ad_height = 90; 
  //--> 
  </script> 
  <script type="text/javascript" 
  src="//pagead2.googlesyndication.com/pagead/show_ads.js">
  </script>
</div>

<div id="verticalPage">
  <div class="breadcrum">
    <?php echo $this->Html->link('home', array(
    'controller' => 'users', 'action'=> 'home')); ?>
      &raquo;
      <span><?php echo "User Leaderboard";?></span>
  </div><!--end of breadcrum-->
  <div class="title_row">
    <h1>User Leaderboard</h1>
    <?php
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
      ?>
  </div><!--end of title_row-->

    <div class="cont_row border">
    <div class="main_content">
      <div class="blocks_holder">
        <div class="block">
          <?php echo $this->element('User/top_users');?>
        </div> <!-- First Block End -->
        <div class="block  block_last">
          <?php echo $this->element('User/most_accurate');?>
        </div> <!-- Second BLock End -->
      </div><!--end of blocks_holder-->
    </div><!--end of main_content-->

    <div class="sidebar">
      <?php echo $this->element('User/lifetime_leader');?>
    </div><!-- .sidebar end -->
  </div><!-- count row end -->
  <div class="table_holder" id="CallTable">
    <?php
      $paginationOption = array(
          'model' => 'Vote',
          'keyId' => 'all',
          'action' => 'user_leaderboard',
          'divId'  => 'CallTable'
        );
    ?>
   
    <div class="table_row">
      <div class="table_btns">
       <h2><a class="on">TOP 100 USERS </a></h2>
      </div>
    </div>
    <?php echo $this->element('User/top_user_table', array('topUsersTable' => $topUsersTable));?>
    <div class="table_row">
    </div>
  </div><!--end of table_holder-->
</div><!-- End of #verticalPage -->
