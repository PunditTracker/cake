<div style="padding-bottom:20px; clear:both; display:block;">
  <script type="text/javascript"><!--
  google_ad_client = "ca-pub-2770130917629235";
  /* Category: Rolling New */
  google_ad_slot = "6022627745";
  google_ad_width = 728;
  google_ad_height = 90;
  //-->
  </script>
  <script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
  </script>
</div>
<?php if (!$this->request->is('ajax')) {  ?>
<div id="verticalPage">
  <?php $options  = Configure::read('radio_vote_option'); ?>
  <div class="breadcrum">
    <?php echo $this->Html->link('home', array(
    'controller' => 'users', 'action'=> 'home')); ?>
      &raquo;
      <span><?php echo !empty($topPundit['Category']['name']) ? $topPundit['Category']['name'] : "All"; ?></span>
  </div><!--end of breadcrum-->

  <div class="title_row">
    <h1><?php echo !empty($topPundit['Category']['name']) ? $topPundit['Category']['name'] : ""; ?> Pundits: Predictions &amp; Picks</h1>
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
  </div><!--end of title_row-->

  <div class="cont_row">
    <div class="main_content">
      <div class="blocks_holder">
        <?php
        echo $this->element('User/home_top_pundit', array('topPundit' => $topPundit, 'categoryId' => 'all'));
        //element for blog post
        echo $this->element(
          'Vertical/vertical_blog_post',
          array(
            'position' => 'block_last',
            'categoryName' => "All"
          ),
          array(
            'cache' => array(
              'config' => 'element_config',
              'key' => "All",
              //'time' => '+1 hour'
            )
          )
        );
        ?>
      </div><!--end of blocks_holder-->
    </div><!--end of main_content-->

    <?php echo $this->element('Vertical/side_bar'); ?>

  </div><!--end of cont_row-->

  <div class="voteToolTip">
    <a href="javascript: return false;" class="btn" id="why_vote" title="<?php echo Configure::read('whyShouldVoteToolTipMsg') ?>"><span>why should i vote?</span></a>
  </div>
  <br style="clear:both;" />
  <div class="table_holder" id="CallTable">
   <?php } ?>
    <div class="table_row">
      <?php
        /*echo $this->element('Common/vertical_view_tabs', array(
        'categoryId' => 'all'
        ));*/
        $paginationOption = array(
          'model' => 'Call',
          'keyId' => 'all',
          'action' => 'category_view',
          'divId'  => 'CallTable'
        );
        echo $this->element('Common/multi_pagination', $paginationOption);
      ?>

    </div><!--end of table_row-->

    <?php
    echo $this->element('Vertical/live_call_table', array('liveCallData' => $liveCallData, 'categoryId' => $categoryId)); ?>

    <div class="table_row">
      <?php echo $this->element('Common/multi_pagination', $paginationOption ); ?>
    </div><!--end of table_row-->
  <?php if (!$this->request->is('ajax')) {  ?>
  </div><!--end of table_holder-->

  <div class="line">line</div>
  <?php
    echo $this->element(
      'Vertical/vertical_pundits',
      array(
        'allCategoriesData' => $allCategoriesData
      )
    );
  ?>

</div><!-- End of #verticalPage -->

<?php } echo $this->Js->writeBuffer(); ?>
