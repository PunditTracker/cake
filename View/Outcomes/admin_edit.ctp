<?php
$ratings = array('0' => '0', '0.25' => '0.25', '0.5' => '0.5', '0.75' => '0.75', '1' => '1');

 ?>
<div class="users form"> 
  <?php echo $this->Form->create('Outcome', array('class' => 'edit_form'));?>
  <h2><?php echo __('Edit Outcome'); ?></h2>    
    <fieldset id="inputs">
    <?php
    echo $this->Form->input(
      'title', 
      array(
	    'label' => array(
	      'text'  => 'Outcome Title'
	    ),
	    'error' => array(
	      'required' => __('Please enter outcome title.')
	    ),
	    'class' => 'input_txt'
      )
    ); 
    echo $this->Form->input(
      'rating', 
      array(
        'label' => array(
          'text'  => 'Rating'
        ),
        'empty'   => __('-- Select --'),
	    'escape'  => false,
	    'error' => array(
	      'required' => __('Please select rating.')
	    ),
	    'options' => $ratings
      )
    );
    ?>
    <div class="actions">
      <?php 
      echo $this->Form->submit(
        __('Update'),
        array(
          'class'=>'btn_submit',
          'div' => false
        )
      );
      ?>           
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>

