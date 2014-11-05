<div class="sidebar">
  <div class="sidebox">
    <div class="sidebox_title"><strong class="with_ico1">help us <span>track</span></strong></div>
    <div class="sidebox_cont">
      <div class="help_txt">Tell us about any new predictions that should be tracked.</div>
      <?php
      $selector = '';
      if ($this->Session->read('Auth.User.id')) {
        $selector = 'suggestCallBox';
      }
      ?>
      <div class="help_submit"><a href="#" id="<?php echo $selector; ?>" class="set-submit btn_submit">Submit</a></div>
    </div>
  </div><!--end of sidebox-->

  <div class="side_img">
    <?php
      echo $this->Html->link(
        $this->Html->image(
          'ad1.jpg',
          array(
            'alt' => '',
            'width' => "300",
            'height' => '250'
          )
        ),
        '',
        array(
          'escape' => false
        )
      );
    ?>
  </div>
  <div class="side_img">
    <?php
      echo $this->Html->link(
        $this->Html->image(
          'side_img.jpg',
          array(
            'alt' => '',
            'width' => "300",
            'height' => '250'
          )
        ),
        '',
        array(
          'escape' => false
        )
      );
    ?>
  </div>

  <div class="side_title">pundittracker featured on</div>
  <ul class="side_logos">
    <li>
      <?php
        echo $this->Html->link(
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
        );
      ?>
    </li>
    <li>
      <?php
        echo $this->Html->link(
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
        );
      ?>
    </li>
    <li>
      <?php
        echo $this->Html->link(
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
        );
      ?>
    </li>
  </ul>
</div><!--end of sidebar-->
