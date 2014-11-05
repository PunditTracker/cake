<div class="users form"> 
  <?php echo $this->Form->create('Category', array('class' => 'edit_form'));?>
  <h2><?php echo __('Edit Category'); ?></h2>    
    <fieldset id="inputs">
    <?php
    echo $this->Form->input(
      'parent_id', 
      array(
        'label' => array(
          'text'  => 'Sub Category of'
        ),
        'empty'   => __('Select from'),
	    'escape'  => false,
      )
    );
    $error = $this->Form->error('name', array('required' => __('Please enter category title.')));
    echo $this->Form->input(
      'name', 
      array(
      'label' => array('text'  => "Category Title" . $error),
      'error' => false,
      'class' => 'input_txt'
      )
    );    
    
    echo $this->Form->input(
      'featured', 
      array(
        'type' => 'checkbox',
        'label' => array(
          'text'  => __('Featured')
        ),
      )
    );
    ?>
    <div class="actions edit_btns">
      <?php 
      echo $this->Form->submit(
        __('Update'),
        array(
          'class'=>'input_submit',
          'div' => false
        )
      );
      ?>           
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>
