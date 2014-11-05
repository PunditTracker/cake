<div class="sidebar">
    <div class="sidebox">
        <div class="sidebox_title"><strong>get in <span>touch</span></strong></div>
        <div class="sidebox_cont">
            <?php
              $selector = 'suggestCallBox';
              $href     = '/calls/add';
              if ($this->Session->read('Auth.User.id')) {
                if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
                  $selector = 'suggestCallBoxByAdmin';
                  $href     = '/admin/calls/add'; 
                }/* else {
                 // $selector = 'suggestCallBox';
                  $href     = '/calls/add';
                }*/
              }
            ?>
            <p>If you have any general feedback or questions about the website, please <a href="mailto:feedback@pundittracker.com">contact us</a>. If you would like to submit a specific predictions or pundit for us to track, please <a id="<?php echo $selector; ?>" class="suggest_call" href="<?php echo $href; ?>" mobile='<?php echo $isMobile; ?>' >click here</a>.</p>
        </div>
    </div><!--end of sidebox-->
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-2770130917629235";
      /* ABOUT1 */
      google_ad_slot = "3070121610";
      google_ad_width = 300;
      google_ad_height = 250;
      //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div><!--end of sidebar-->