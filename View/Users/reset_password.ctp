<div class="Users form" id="cboxContent">
  <?php echo $this->Form->create('User', array('class' => 'edit_form user_edit_form'));?>
    <h2><?php echo __('RESET PASSWORD'); ?></h2>
    <div id="inputs" class="edit_row">
    <?php
     $error = $this->Form->error('old_password');
      echo $this->Form->input(
        'old_password',
        array(
          'type' => 'password',
          'placeholder' => 'Old password',
          'label' => array('text' => "Old password" . $error),
          'class' => 'input_txt',
          'error' => false,
        )
      );
      $error = $this->Form->error('password', array('required' => __('Please enter password')));
      echo $this->Form->input(
        'password',
        array(
          'placeholder' => 'New Password',
          'label' => array('text' => "New password" . $error),
          'error' => false,
          'class' => 'input_txt',
        )
      );
      $error = $this->Form->error('password2', array(
        'required' => __('Please confirm your password'),
        'confirm' => __('password could not matched')
      ));
      echo $this->Form->input(
        'password2',
        array(
          'label' => array('text' => "Confirm password" . $error),
          'placeholder' => 'Confirm Password',
          'type' => 'password',
          'error' => false,
          'class' => 'input_txt',
        )
      );
    ?>
    </div>
    <div class="actions edit_btns">
      <?php
      echo $this->Form->submit(
        __('Save'),
        array(
          'class'=>'input_submit',
          'div' => false,
        )
      );
       echo $this->Html->link(
        __('Cancel'),
        array('controller' => 'users', 'action' => 'profile'),
        array(
          'class'=>'btn_cancel remove-border',
          'div' => false,
          'id' => 'closeIframe'
        )
      );
      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>

