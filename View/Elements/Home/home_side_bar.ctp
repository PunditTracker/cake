<div class="sidebar">

     <?php echo $this->element('User/home_top_pundit', array('topPundit' => $topPundit));
      echo $this->element('User/featured_user');
      ?>


  <div class="side_img">
    <!--<SCRIPT charset="utf-8" type="text/javascript"
    src="http://ws.amazon.com/widgets/q?rt=tf_mfw&ServiceVersion=20070822&MarketPlace=US&ID=V20070822/US/pundittrcom-20/8001/b8c3cecb-21c7-497b-9ca4-877857d471bb">
    </SCRIPT> <NOSCRIPT><A
    HREF="http://ws.amazon.com/widgets/q?rt=tf_mfw&ServiceVersion=20070822&MarketPlace=US&ID=V20070822%2FUS%2Fpundittrcom-20%2F8001%2Fb8c3cecb-21c7-497b-9ca4-877857d471bb&Operation=NoScript">Amazon.com
    Widgets</A></NOSCRIPT>-->
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
    <!--
<?php
      echo $this->Html->link(
        $this->Html->image(
          'pundit_ad_v2.jpg',
          array(
            'alt' => '',
          )
        ),
        "http://blog.pundittracker.com/can-you-predict-better-than-the-experts-prove-it/",
        array(
          'escape' => false
        )
      );
    ?>-->
  </div>

  <div class="side_img">
    <script type="text/javascript"><!--
      google_ad_client = "ca-pub-2770130917629235";
      /* PT Home1 */
      google_ad_slot = "5599117259";
      google_ad_width = 300;
      google_ad_height = 250;
      //-->
      </script>
      <script type="text/javascript"
      src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
  </div>

  <div class="side_title">pundittracker featured on</div>

  <ul class="side_logos">
    <li>
      <?php
        /*echo $this->Html->link(
          $this->Html->image(
            'logo_time.png',
            array(
              'alt' => '',
              'width' => "135",
              'height' => '60'
            )
          ),
          '',
          array(
            'escape' => false
          )
        );*/
        echo $this->Html->link(
          $this->Html->image(
            'logo_npr.png',
            array(
              'alt' => '',
              'width' => "135",
              'height' => '60'
            )
          ),
          "http://www.onthemedia.org/2012/mar/09/pundit-tracker/",
          array(
            'escape' => false
          )
        );
      ?>
    </li>
    <li>
      <?php
        echo $this->Html->link(
          $this->Html->image(
            'logo-deadspin.jpg',
            array(
              'alt' => '',
              'width' => '245px',
              'height' => '50px'
            )
          ),
          'http://deadspin.com/pundit-tracker/',
          array(
            'escape' => false
          )
        );
      ?>
    </li>
    <li>
      <?php
        echo $this->Html->link(
          $this->Html->image(
            'logo-politico.png',
            array(
              'alt' => '',
              'width' => '191px',
              'height' => '52px'
            )
          ),
          'http://www.politico.com/story/2013/02/site-grades-pundits-on-their-predictions-87622.html',
          array(
            'escape' => false
          )
        );
      ?>
    </li>
    <li>
      <?php
        /*echo $this->Html->link(
          $this->Html->image(
            'logo_hbr.png',
            array(
              'alt' => '',
              'width' => "135",
              'height' => '60'
            )
          ),
          '',
          array(
            'escape' => false
          )
        );*/
      ?>
    </li>
    <li>
      <?php
        /*echo $this->Html->link(
          $this->Html->image(
            'logo_freak.png',
            array(
              'alt' => '',
              'width' => "135",
              'height' => '60'
            )
          ),
          '',
          array(
            'escape' => false
          )
        );*/
      ?>
    </li>
  </ul>
</div><!--end of sidebar-->
