
<div class="Pundit form" id="cboxContent">
  <?php echo $this->Form->create('User', array('url' => array('controller' => 'SuggestedPundits', 'action' => 'admin_add'), 'class' => 'edit_form user_edit_form', "type" => "file"));?>
  <h2><?php echo __('Add Pundit'); ?></h2>
    <div id="inputs" class="edit_row">     
      <?php
      $this->request->data['User']['avatar'] = null;
      echo $this->element(
        'Common/image_box',
        array(
          'allData'       => $this->request->data,
          'linkClassName' => $linkClassName,
          'className'     => $className
        )
      ); ?>      
      <div class="featured">
        <label for="CallFeatured_">Featured</label>
        <?php
        echo $this->Form->input(
          'Pundit.featured',
          array(
            'label' => false,
            'type' => 'checkbox',

          )
        );
        ?>
      </div>
      <?php
      if (isset($suggestedPunditEdit)) {
        echo $this->Form->input('SuggestedPundit.id', array('type' => 'hidden'));
      }
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
    
      $error = $this->Form->error('SuggestedPundit.category_id', array('required' => 'Please select category.'));
	    echo $this->Form->input(
	      'Category.category_id', 
	      array(      
	        'empty'   => __('-- Select --'),
	        'label' => array(
	          'text'  => "Category".$error
	        ),  
	        'error' => false,
	        'escape'  => false,
	      )
	    );
      echo $this->Form->input(
        'email',
        array(
          'label' => array('text' => "Email"),
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
      ?>     
      
    </div>
    <div class="actions edit_btns">
      <?php
      echo $this->Form->submit(
        __('Save & Approve'),
        array(
          'class'=>'input_submit',
          'div' => false,
        )
      );
       echo $this->Form->submit(
        __('Cancel'),
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

