<div class="users form">
  <?php echo $this->Form->create('Call', array('action' => 'upload_csv', 'type' => 'file', 'class' => 'edit_form')); ?>
    <h2><?php echo __('Upload CSV'); ?></h2>

    <?php if (!empty($validateCall)) : ?>
      <div id="content" class="validationError" >
        <h3>Validation errors</h3>        
        <?php        
        foreach($validateCall as $row => $data) {
          $errorMsg = $message = array();
          if (isset($data['error']['created'])) {
            @$message['created'] = in_array('notempty', $data['error']['created']) ? __('Date made can not be empty') : '';
          }
      
          if (isset($data['error']['due_date'])) {
            @$message['due_date'] = in_array('Please select', $data['error']['due_date']) ? __('Due date can not be empty') : $data['error']['due_date'][0];
          }

          if (isset($data['error']['vote_end_date'])) {
            @$message['vote_end_date'] = in_array('Please select', $data['error']['vote_end_date']) ? __('Vote end date can not be empty') : $data['error']['vote_end_date'][0];
          }

          if (isset($data['error']['source'])) {
            @$message['source'] = in_array('notempty', $data['error']['source']) ? __('Source can not be empty') : '';
          }

          if (isset($data['error']['prediction'])) {
            @$message['prediction'] = in_array('notempty', $data['error']['prediction']) ? __('Prediction can not be empty') : '';
          }

          if (isset($data['error']['ptvariable'])) {
            @$message['ptvariable'] = in_array('numeric', $data['error']['ptvariable']) ? __('PTvariable can be only numeric') : '';
          }

          if (!empty($message)) {
          $errorMsg = implode(', ', $message);
         
          }
          echo $row .'&nbsp;&nbsp;&#8250;&#8250;&nbsp;&nbsp;'. (string)$data['prediction']. '&nbsp;&nbsp;&#8250;&#8250;&nbsp;&nbsp;<span class="error-message">' . $errorMsg . "</span><br/>";
        }
        ?>  
           
      </div>
    <?php endif; ?>

    <fieldset id="inputs">
      <?php
        if (isset($invalidError['user_id'])) :
          $errorMsg['pundit'] = in_array('notempty', $invalidError['user_id']) ? __('Please select pundit') : '';   

          $errorPundit = ($errorMsg['pundit']) ? '<div class="error-message">'.$errorMsg['pundit'].'</div>' : '';           
        endif;
        
        echo $this->Form->input(
          'user_id', 
          array(      
            'empty'   => __('-- Select --'),
            'label' => array('text' => "Pundit" . @$errorPundit),
            'error' => false,
            'escape'  => false,        
          )
        ); 
        echo $this->Form->input('csv_file', array(
          'type' => 'file',
          'class' => '',     
          'error' => false,   
          'label' => array(
            'class' => 'label', 
            'text'  => __('Upload File'),
            ),
          )
        );

      if (isset($invalidError['csv_file'])) {
      $errorMsg['csv_file'] = in_array('extension', $invalidError['csv_file']) ? __('Please choose correct csv file') : '';   ?>
      <div class="error-message"><?php echo @$errorMsg['csv_file']; ?></div>
      <?php }

      echo $this->Form->input('date_format', array(
        'type' => 'radio',
        'options' => array(
          '1' => 'All dates are DD/MM/YY', 
          '2' => 'All dates are MM/DD/YY'
        ),
        'default' => 1,
        'div' => array('class' => "input"),
        'legend' => false,
        'before' => '<label class="label" for="CallUserId">Date Format</label>'
        )
      );
     
      ?>
      <div class="actions edit_btns">
        <?php 
        echo $this->Form->submit(
          __('Upload'),
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
</div>

