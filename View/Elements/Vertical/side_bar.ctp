<div class="sidebar">
  <div class="side_img">
    <!--script type="text/javascript"><!--
      google_ad_client = "ca-pub-2770130917629235";
      /* Category1 */
      google_ad_slot = "6059588089";
      google_ad_width = 300;
      google_ad_height = 250;
      //-->
    </script-->
    <!--script type="text/javascript"
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
  </div>
</div><!--end of sidebar-->
