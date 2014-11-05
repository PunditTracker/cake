<div class="Users form" id="cboxContent">
  <?php echo $this->Form->create('User', array('class' => 'edit_form user_edit_form', "type" => "file"));?>

    <div id="inputs" class="edit_row">
      <?php
      echo $this->element(
        'Common/image_box',
        array(
          'allData'       => $this->request->data,
          'linkClassName' => $linkClassName
        )
      ); ?>
      <?php
      echo $this->Form->input('fb_id', array('type' => 'hidden'));
      $error = $this->Form->error('first_name');
      echo $this->Form->input(
        'first_name',
        array(
          'placeholder' => 'First Name',
          'error' => false,
          'label' => array('text' => "First Name" . $error),
          'class' => 'input_txt',
          'div' => array('class' => 'separateDiv'),
        )
      );
      $error = $this->Form->error('last_name');
      echo $this->Form->input(
        'last_name',
        array(
          'placeholder' => 'Last Name',
          'error' => false,
          'label' => array('text' => "Last Name" . $error),
          'class' => 'input_txt',
          'div' => array('class' => ''),
        )
      );
      $error = $this->Form->error('email');
      echo $this->Form->input(
        'email',
        array(
          'label' => array('text' => "Email" . $error),
          'placeholder' => 'Email Address',
          'error' => false,
          'class' => 'input_txt input_txt2'
        )
      );
      echo $this->Form->input(
        'biography',
        array(
          'class' => 'textarea-height',
        )
      );
      echo $this->Form->input(
        'private',
        array(
          'class' => '',
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

