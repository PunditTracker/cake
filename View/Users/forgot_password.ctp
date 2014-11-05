<div class="Users form" id="cboxContent">
  <?php echo $this->Form->create('User', array('class' => 'edit_form user_edit_form'));?>
  <h2><?php echo __('FORGOT PASSWORD ???'); ?></h2>
  <?php //echo $this->Session->flash(); ?>
    <div id="inputs" class="edit_row">
    <?php
      echo $this->Form->input(
      'email',
      array(
        'label' => array(
          'text' => 'Email' . $this->Session->flash()
        ),
        'placeholder' => 'Email Address',
        'class' => 'input_txt input_txt2',
        'error' => false
      )
    );
    ?>
    </div>
    <div class="actions edit_btns">
      <?php
        echo $this->Form->submit(
          __('Submit'),
          array(
            'class'=>'input_submit',
            'div' => false,
          )
        );
        if (!$isMobile) {
          echo $this->Form->submit(
            __('Cancel'),
            array(
              'class'=>'btn_cancel remove-border',
              'div' => false,
              'id' => 'closeIframe'
            )
          );
        }
      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>

