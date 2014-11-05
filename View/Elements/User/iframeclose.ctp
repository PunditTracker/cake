<?php $option = Configure::read('radio_vote_option'); ?>

<div class="Users form" id="cboxContent">
  <?php echo $this->Form->create('User', array('class' => 'edit_form user_edit_form'));?>
    <h2><?php echo __('RESET EMAIL SENT'); ?></h2>
    <?php echo $this->Session->flash(); ?>
    <div class="actions edit_btns">
      <?php
       echo $this->Form->submit(
        __('Close'),
        array(
          'class'=>'btn_cancel remove-border',
          'div' => false,
          'id' => 'closeIframe'
        )
      );
      ?>
    </div>
  <?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">

  $(function(){  
    
    setTimeout(parent.$.fn.colorbox.close, 5000);  
    
  });

</script>