<div class="Users form" id="cboxContent">
  <?php echo $this->Form->create('User', array('class' => 'edit_form user_edit_form', "type" => "file"));?>

    <div id="inputs" class="edit_row">
      <?php
      echo $this->element(
        'Common/image_box',
        array(
          'allData'       => $this->request->data,
          'linkClassName' => $linkClassName
        )
      ); ?>
      <div class="featured">
        <label for="CallFeatured_">Featured</label>
        <?php
        echo $this->Form->input(
          'featured',
          array(
            'label' => false,
            'type' => 'checkbox',
            'style' => 'margin-bottom:15px;'
          )
        );
        ?>
      </div>
      <?php
      echo $this->Form->input('id', array('type' => 'hidden'));
      echo $this->Form->input('fb_id', array('type' => 'hidden'));
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
      $error = $this->Form->error('category_id', array('notempty' => 'Please select category.'));
      echo $this->Form->input(
        'Category.Category',
        array(
          'empty'   => __('-- Select --'),
          'label' => array(
            'text'  => "Category" . $error
          ),
          'multiple' => true,
          'size' => 5,
          'type' => 'select',
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
        __('Save'),
        array(
          'class'=>'input_submit',
          'div' => false,
        )
      );
      echo $this->Html->link(
        __('Cancel'),
        array('action' => 'profile', 'admin' => false, $this->request->data['User']['id']),
        array(
          'class'=>'btn_cancel remove-border',
          'id' => 'closeIframe'
        )
      );
      echo $this->Html->link(
        __('Delete'),
        array(
          'action' => 'delete',
          'admin' => true,
          $punditId
        ),
        array(
          'class' => 'btn_deny',
          //'id' => 'CategoryRemove'
        ),
        __('Are you sure you want to delete this pundit #%s?',
        $punditId)
      );

      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>

