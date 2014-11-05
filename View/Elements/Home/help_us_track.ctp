<div class="sidebox block">
  <div class="sidebox_title"><strong class="with_ico1">help us <span>track</span></strong></div>
  <div class="sidebox_cont">
    <div class="help_txt">Tell us about any new predictions that should be tracked.</div>
    <?php
    $selector = 'suggestCallBox';
    $action   = array('controller' => 'calls', 'action' => 'add', 'admin' => false);
    if ($this->Session->read('Auth.User.id')) {
      if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
        $selector = 'suggestCallBoxByAdmin';
        $action   = array('controller' => 'calls', 'action' => 'add', 'admin' => true);
      }/* else {
        //$selector = 'suggestCallBox';
        $action   = array('controller' => 'calls', 'action' => 'add', 'admin' => false);
      }*/
      //$selector = 'suggestCallBox';
    }
    ?>
    <div class="help_submit">
      <?php echo $this->Html->link('Submit', $action, array('id' => $selector, 'class' => 'set-submit btn_submit', 'mobile' => $isMobile)); ?>
    </div>
  </div>
</div><!--end of sidebox-->