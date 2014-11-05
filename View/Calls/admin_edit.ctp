<div class="suggestedCall form" id="cboxContent1">
  <?php echo $this->Form->create('Call', array('class' => 'edit_form', 'id' => 'CallAdminEditForm'));?>
    <h2>
      <?php 
      if (isset ($formHeading)) {
        echo $formHeading;
      } else {
        echo __('EDIT');
      }
      ?>
    </h2>
    <div id="inputs" class="edit_row">
    <?php
   /* if (!isset($currentPunditId)) {
      $punditId = null;
    } else {
      $punditId = $currentPunditId;
    }*/
    
    $category_error = $this->Form->error('category_id', array('notempty' => 'Please select category.'));
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
        //'value'  => 'getPunditsList(this.value)'
        //'default' => $punditId,
        //'onchange' => 'getvalue(this.value)',
      )
    );
    
    /*
    $error = $this->Form->error('user_id', array('notempty' => __('Please select pundit')));
    echo $this->Form->input(
      'user_id',
      array(
        'empty' => __('-- Select --'),
        'label' => array('text' => "Pundit" . $error),
        'error' => false,
        'onchange' => 'getvalue(this.value)',
        'escape'  => false,
        'div' => array('class' => 'pull-left'),
        'default' => $punditId
      )
    );
    
    echo $this->Form->unlockField('category_id');
    $currentCategory = '';
    if (isset($this->request->data['Call']['category_id']) && !empty($this->request->data['Call']['category_id'])){
      $currentCategory = array(
        $this->request->data['Call']['category_id'] => $categories[$this->request->data['Call']['category_id']]
      );
    }
    $empty = __('-- Select --');
    if (isset($punditCategories)) {
      $currentCategory = $punditCategories;
      if (count($punditCategories) == 1) {
        if (isset($formHeading)) {
          $empty = false;
        }
      }
    }
    $error = $this->Form->error('category_id', array('notempty' => __('Please select category')));
    echo $this->Form->input(
      'category_id',
      array(
        'empty' => $empty,
        'options' =>  $currentCategory,
        'label' => array('text' => "Category" . $error),
        'error' => false,
        'default' => $currentCategory
      )
    );*/
    $error = $this->Form->error('prediction', array('notempty' => __('Please enter prediction')));
    echo $this->Form->input(
      'prediction',
      array(
        'label' => array('text' => "Prediction" . $error),
        'error' => false,
        'class' => 'input_txt input_txt2'
      )
    ); 
    ?>
    <div class="pull-left required">
      <label for="CallYield">Yield</label>
      <span id= "callYield">
        <?php
        $yield = isset($this->request->data['Call']['yield']) ? $this->request->data['Call']['yield'] : 0;
         echo "$".$yield;
        ?>
      </span>
    </div>    
    <?php
    $error = $this->Form->error('ptvariable', array(
      'numeric' => __('should be number'),    
    ));
    $ptvariableValue = isset($this->request->data['Call']['ptvariable']) ? $this->request->data['Call']['ptvariable'] : '1.0';
    echo $this->Form->input(
      'ptvariable',
      array(       
        'type' => 'text',
        'value' => $ptvariableValue,
        'label' => array('text' => "PT Variable" . $error),
        'error' => false,
        'class' => 'input_txt_small',
        'div' => array('class' => 'pull-left')
      )
    );
    
    /*
    echo $this->Form->input(
      'yield',
      array(
        'label' => array('text' => "$1 Yield"),
        'error' => false,
        'class' => 'input_txt_small',
        'div' => array('class' => 'pull-left'),
        'disabled' => true
      )
    );*/
    echo $this->Form->input(
      'boldness',
      array(
        'label' => array('text' => "Boldness"),
        'error' => false,
        'class' => 'input_txt_small'
      )
    );
    $error = $this->Form->error('created', array('notempty' => __('Please select')));
    $createdDate = isset($this->request->data['Call']['created'])?$this->request->data['Call']['created']:'';
    echo $this->Form->input(
      'created',
      array(
        'type' => 'text',
        'label' => array('text' => "Date Made". $error),
        'value' => $this->PT->dateFormat($createdDate),
        'error' => false,
        'class' => 'input_txt small',
        'div' => array('class' => 'pull-left'),
        'id' => 'dateMade'
      )
    );
    $dueDate = isset($this->request->data['Call']['due_date'])?$this->request->data['Call']['due_date']:'';
    $error = $this->Form->error('due_date', array('notempty' => __('Please select')));
    echo $this->Form->input(
      'due_date',
      array(
        'type' => 'text',
        'label' => array('text' => "Date Due" . $error),
        'value' => $this->PT->dateFormat($dueDate),
        'error' => false,
        'class' => 'input_txt small due_date',
        'div' => array('class' => 'pull-left'),
        'id' => 'dateDue'
      )
    );
    $voteEndDate = isset($this->request->data['Call']['vote_end_date'])?$this->request->data['Call']['vote_end_date']:'';
    $error = $this->Form->error('vote_end_date', array('notempty' => __('Please select')));
    echo $this->Form->input(
      'vote_end_date',
      array(
        'type' => 'text',
        'label' => array('text' => "Vote Until" . $error),
        'value' => $this->PT->dateFormat($voteEndDate),
        'error' => false,
        'class' => 'input_txt small',
        'id' => 'voteUntil'
      )
    );
    $error = $this->Form->error('outcome_id', array('notempty' => __('Please select')));
    echo $this->Form->input(
      'outcome_id',
      array(
        'empty' => __('-- Select --'),
        'label' => array('text' => "Outcome" . $error),
        'error' => false,
        'escape' => false,
        'div' => array('class' => 'pull-left edit_block'),
      )
    );
    $error = $this->Form->error('source', array('notempty' => __('Please enter source')));
    echo $this->Form->input(
      'source',
      array(
        'error' => false,
        'label' => array('text' => "Link/Source" . $error),
        'class' => 'input_txt',
        'div' => array('class' => 'pull-left'),
      )
    );
    ?>
    <div class="separateDiv"></div>
    <div class="pull-left" style="margin-right: 40px">
      <label for="CallFeatured_">Featured</label>
      <?php
      echo $this->Form->input(
        'featured',
        array(
          'label' => false,
          'type' => 'checkbox',
          'style' => 'margin-bottom: 15px;'
        )
      );
      ?>
    </div>
    <div>
      <label for="CallIsCalculated">Calculate Boldness via votes</label>
      <?php
      echo $this->Form->input(
        'is_calculated',
        array(
          'label' => false,
          'type' => 'checkbox',
        )
      );
      ?>      
    </div>
    <div class="actions edit_btns">
      <?php
      if (isset ($formHeading)) {
        echo $this->Html->link('upload via csv', array(),
          array('class' => 'uploadCsvLink')
        );
      }
      echo $this->Form->submit(
        __('Save'),
        array(
          'class'=>'input_submit',
          'div' => false,
        )
      );
  
       echo $this->Html->link(
        __('Cancel'),
        ($isMobile) ? $this->Session->read('refLocation') : '',
        /*array(
          'controller' => 'categories', 
          'action' => 'view', 
          'admin' => false, 
          @strtolower($categories[$this->request->data['Call']['category_id']])
        ),*/
        array(
          'class'=>'btn_cancel remove-border',
          //'div' => false,
          'id' => 'closeIframe'
        )
      );
      echo $this->Form->end(); ?>
      <?php
      if (!isset ($formHeading)) {
        echo $this->Form->postLink(
          __('Delete'), 
          array(
            'controller' => 'calls',
            'action' => 'delete', 
            'admin' => true,
            $predictionId
          ), 
          array(
            'class' => 'delete-border'
          ), 
          __('Are you sure you want to delete this call # %s?', $predictionId) 
        );
      }
      ?>
    </div>
  </div>
  
</div>

