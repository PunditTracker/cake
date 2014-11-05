<?php
$category = Configure::read('category_ico');
$options  = Configure::read('radio_vote_option');
?>

<div class="cont_row" id='home'>
  <div class="main_content">
    <?php
      // element for home page image slider
      echo $this->element('Common/home_slider_img'); ?>

    <div class="title_row2">
      <h1>FEATURED PREDICTIONS</h1>
      <a href="<?php echo Router::url(array('controller' => 'categories', 'action' => 'view', 'all')); ?>" class="btn" title=""><span><?php echo __('View all open Predictions'); ?></span></a>
    </div>
    <div id='flashMessage' class="hide"></div>
    <div class="title_line">line</div>
    <div id="featuredCall">
    <?php
    $count = count($calls);
    $i = 0;
    foreach($calls as $call) :
      $i++;
      if (empty($call['Call']['outcome_id']) && $this->PT->dateDiff($call['Call']['vote_end_date']) != false) {
        echo $this->element('Home/live_call',
          array(
            'call'   => $call,
            'options'   => $options,
            'category' => $category
          )
        );

      } else {
        $class = 'vote_box2 vote_col';
        if($count == $i) {
          $class = 'vote_box2 vote_col vote_col_last';
        }
        echo $this->element('Home/archive_call',
          array(
            'call'   => $call,
            'options'   => $options,
            'category' => $category,
            'boxClass' => $class
          )
        );
      }
    endforeach;
    ?>
    </div>
    <div class="blocks_holder blocks_holder_home">

      <?php
      echo $this->element('Home/help_us_track');

      if (!empty($topUser)) {
        //echo $this->element('Vertical/top_users', array('topUser' => $topUser));
        $blogPosition = 'blog';
      } else {
        $blogPosition = 'block_last';
      }
      ?>
      <div class= "block_last">
      <?php
      //element for blog post
      echo $this->element(
        'Common/blog_post',
        array('position' => 'block_last'),
        array(
          'cache' => array(
            'config' => 'element_config',
            //'time' => '+1 hour'
          )
        )
      );
      ?>
      </div>
    </div><!--end of blocks_holder-->
  </div><!--end of main_content-->
  <?php
    // element for side bar on home page
    echo $this->element('Home/home_side_bar', array('topPundit' => $topPundit)); ?>

</div><!--end of cont_row-->
