<div class="suggestedPundit form">   
  <?php echo $this->Form->create('SuggestedPundit', array('class' => 'edit_form'));?>
  <h2><?php echo __('Suggest A Pundit'); ?></h2>    
    <fieldset id="inputs">
    <?php
    echo $this->Form->input(
      'category_id', 
      array( 
        'label' => array(
          'text'  => 'Category' . $this->Form->error('category_id', __('Please select category'))
        ),     
        'empty'   => __('-- Select --'),
        'error' => false,
        'escape'  => false
      )
    );
    echo $this->Form->input(
      'pundit_name', 
      array(
        'label' => array(
          'text'  => 'Pundit Name' . $this->Form->error('pundit_name', __('Please enter pundit name'))
        ),
        'class' => 'input_txt',
        'error' => false
      )
    ); 
    ?>
    <div class="actions edit_btns">
      <?php 
      echo $this->Form->submit(
        __('Submit'),
        array(
          'class'=>'input_submit',
          'div' => false,
          'id' => 'addNewPunditButton'
        )
      );
      ?>           
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>

