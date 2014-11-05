<div class="users">
<?php echo $this->Form->create('User');?>
  <fieldset>
    <legend><?php echo __('Edit User'); ?></legend>
  <?php
    echo $this->Form->input('first_name', array(
      'error' => array(
        'notempty' => __('Please enter your first name')
          )
    ));
    echo $this->Form->input('last_name', array(
      'error' => array(
        'notempty' => __('Please enter your last name'),
      )
    ));
    echo $this->Form->input('email', array(
      'error' => array(
        'notempty' => __('Please enter email address'),
        'email' => __('Please enter valid email address'),
        'unique' => __('This email address already exist'),
      )
    ));  
    echo $this->Form->input('group_id', array('default' => $this->request->data['ARO']['parent_id']));
  ?>
  </fieldset>
  <div class="actions">
    <?php echo $this->Form->submit(__('Update'));?>           
  </div>
  <?php echo $this->Form->end(); ?>
</div>
