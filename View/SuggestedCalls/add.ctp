<div class="suggestedCall form">   
  <?php echo $this->Form->create('SuggestedCall', array('class' => 'edit_form'));?>
  <h2><?php echo __('Suggest A Prediction'); ?></h2>    
    <fieldset id="inputs">
    <?php  
    if (!isset($punditId)) {
      $punditId = null;
    }
    //echo $this->Form->unlockField('category_id');  
 
    
    $error = $this->Form->error('pundit_name', array('notempty' => 'Please Enter pundit Name.')) ;
    echo $this->Form->input(
      'pundit_name', 
      array(   
        'label' => array('text' => "Pundit Name" . $error),   
        'error' => false,
        'class' => 'input_txt'
      )
    ); 
    
    $error = $this->Form->error('prediction', array('notempty' => 'Please enter prediction.'));
    echo $this->Form->input(
      'prediction', 
      array(   
        'label' => array('text' => "Prediction" . $error),   
        'error' => false,
        'class' => 'input_txt'
      )
    ); 
    $error = $this->Form->error('created', array('notempty' => 'Select date.')); 
    echo $this->Form->input(
      'created', 
      array(   
        'type' => 'text',
        'label' => array('text' => "Date Made" . $error),
        'class' => 'input_txt small',
        'div' => array('class' => 'pull-left'),
        'id' => 'dateCreated',
        'error' => false
      )
    ); 
    
    $error = $this->Form->error('source', array('notempty' => 'Please enter source.'));
    echo $this->Form->input(
      'source', 
      array(   
        'label' => array('text' => "Link/Source" . $error),   
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


