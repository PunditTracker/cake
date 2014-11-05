<div class="suggestedCall form">   
  <?php echo $this->Form->create('SuggestedCall', array('class' => 'edit_form'));?>
  <h2><?php echo __('Suggest A Prediction'); ?></h2>    
    <fieldset id="inputs">
    <?php  
    if (!isset($punditId)) {
      $punditId = null;
    }
    $error = $this->Form->error('pundit_name', array('notempty' => 'Please Enter pundit Name.')) ;
    echo $this->Form->input(
      'pundit_name', 
      array(   
        'label' => array('text' => "Pundit Name" . $error),   
        'error' => false,
        'class' => 'input_txt'
      )
    ); 
    //echo $this->Form->unlockField('category_id');  
    /*$category_error = $this->Form->error('category_id', array('notempty' => 'Please select category.'));
    echo $this->Form->input(
      'category_id', 
      array( 
        'empty' => __('-- Select --'),
        'label' => array('text' => "Category" . $category_error),
        'error' => false,
        'div'   => array('class' => 'pull-left'),
        'onchange' => 'getPunditsList(this.value)',
        'escape'  => false,
      )
    );
    $error = (!$category_error) ?
    $this->Form->error('user_id', array('notempty' => 'Please select pundit.')) : null;
    echo $this->Form->input(
      'user_id', 
      array(      
        'empty'   => __('-- Select --'),
        'label' => array('text' => "Pundit" . $error),
        'error' => false,
        'escape'  => false,
        'default' => $punditId,
        //'onchange' => 'getvalue(this.value)',
      )
    );  */
    /*
    echo $this->Form->unlockField('category_id');  
    echo $this->Form->input('category_id', array(    
      'options' =>  array(), 
      'empty'   => __('-- Select --'),
      'error' => array(
          'notempty' => __('Please select category.')
      ),   
      )
    );*/
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

