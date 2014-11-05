<?php //debug($this->request->data);
$userInfo = $this->request->data;
?>

<div class="admin_user_view">
  <h2><?php echo escape($userInfo['User']['first_name']).' '.escape($userInfo['User']['last_name']); ?></h2>
  <div class="user_per_img">
    <?php
    $imgPath = $this->PT->setImage($this->request->data['User']['avatar'], $this->request->data['User']['fb_id']);
    echo $this->Html->image($imgPath, array('alt' => '', 'height' => 64, 'width' => 64));
    ?>
  </div>
  <div>
    <div>
      <div class="div_heading"><strong><?php echo __('First Name'); ?></strong></div>
      <div class="div_content">
      <?php
        if (!empty ($userInfo['User']['first_name'])) {
          echo escape($userInfo['User']['first_name']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
    <div>
      <div class="div_heading"><strong><?php echo __('Last Name'); ?></strong></div>
      <div class="div_content">
      <?php
        if (!empty ($userInfo['User']['last_name'])) {
          echo escape($userInfo['User']['last_name']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
    <div>
      <div class="div_heading"><strong><?php echo __('Email'); ?></strong></div>
      <div class="div_content">
      <?php
        if (!empty ($userInfo['User']['email'])) {
          echo escape($userInfo['User']['email']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
    <div>
      <div class="div_heading"><strong><?php echo __('Facebook Id'); ?></strong></div>
      <div class="div_content">
        <?php
        if (!empty ($userInfo['User']['fb_id'])) {
          echo escape($userInfo['User']['fb_id']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
    <div>
      <div class="div_heading"><strong><?php echo __('Facebook Access Token'); ?></strong></div>
      <div class="div_content">
      <?php
        if (!empty ($userInfo['User']['fb_access_token'])) {
          echo escape($userInfo['User']['fb_access_token']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
    <div>
      <div class="div_heading"><strong><?php echo __('Biography'); ?></strong></div>
      <div class="div_content">
      <?php
        if (!empty ($userInfo['User']['biography'])) {
          echo escape($userInfo['User']['biography']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
    <div>
      <div class="div_heading"><strong><?php echo __('Score'); ?></strong></div>
      <div class="div_content">
      <?php
        if (!empty ($userInfo['User']['score'])) {
          echo escape($userInfo['User']['score']);
        } else {
          echo '-';
        } ?>
      </div>
    </div><br/>
  </div>
</div>

