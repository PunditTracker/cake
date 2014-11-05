<div class="users form"> 
  <?php echo $this->Form->create('User');?>
  <fieldset>
    <legend><?php echo __('New User'); ?></legend>
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
    echo $this->Form->input('password', array(
      'error' => array(
        'required' => __('Please enter password')
      )
    ));
    echo $this->Form->input('password2', array(
      'label' => array('text' => 'Confirm password'), 
      'type' => 'password',  
      'error' => array(
            'required' => __('Please confirm your password'),
            'confirm' => __('password could not matched')
      )
    ));   
    echo $this->Form->input('group_id');         
  ?>
    <div class="actions">
      <?php echo $this->Form->submit(__('Submit'));?>           
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>
