<div class="suggestedPundit form" id="cboxContent">   
  <?php echo $this->Form->create('SuggestedPundit', array('class' => 'edit_form'));?>
  <h2><?php echo __('Pundit Suggestion'); ?></h2>    
    <fieldset id="inputs">
    <?php  
    $error = $this->Form->error('category_id', array('notempty' => 'Please select category.'));
    echo $this->Form->input(
      'category_id', 
      array(      
        'empty'   => __('-- Select --'),
        'label' => array(
          'text'  => "Category" . $error
        ),
        'error' => false,
        'escape'  => false,
      )
    );   
    $error = $this->Form->error('pundit_name', array('notempty' => 'Please enter pundit name.'));
    echo $this->Form->input(
      'pundit_name', 
      array(
        'label' => array(
          'text'  => "Pundit Name" . $error
        ),
        'error' => false,
        'class' => 'input_txt'
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

