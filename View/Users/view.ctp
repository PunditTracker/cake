<div class="users">
<h2><?php  echo __('User');?></h2>
  <dl>    
    <dt class = "span3"><?php echo __('Email'); ?></dt>
    <dd>
      <?php echo escape(h($user['User']['email'])); ?>
      &nbsp;
    </dd>
    <dt class = "span3"><?php echo __('First name'); ?></dt>
    <dd>
      <?php echo escape(h($user['User']['first_name'])); ?>
      &nbsp;
    </dd>
    <dt class = "span3"><?php echo __('Last name'); ?></dt>
    <dd>
      <?php echo escape(h($user['User']['last_name'])); ?>
      &nbsp;
    </dd>       
    <dt class = "span3"><?php echo __('Created'); ?></dt>
    <dd>
      <?php echo escape(h($user['User']['created'])); ?>
      &nbsp;
    </dd>
    <dt class = "span3"><?php echo __('Modified'); ?></dt>
    <dd>
      <?php echo escape(h($user['User']['modified'])); ?>
      &nbsp;
    </dd>
  </dl>
</div>
