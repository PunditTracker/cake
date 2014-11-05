<div class="imgRow">
  <div class="col1">
    <?php        
    $this->request->data = $allData;
    if (!empty($this->request->data['User']['fb_id'])) {
      echo $this->Form->label('My Picture (from Facebook)');         
    } else {
      echo $this->Form->label('My Picture');         
    }
    $fbId = isset($this->request->data['User']['fb_id']) ? $this->request->data['User']['fb_id'] : null;
    $imgPath = $this->PT->setImage($this->request->data['User']['avatar'], $fbId);
    echo $this->Html->image($imgPath, array('label' => false, 'alt' => '', 'height' => 64, 'width' => 64)); ?>
  </div>
  <div class="col2">          
    <span id="changeAvtarSpan">
      <?php
      if (!empty ($this->request->data['User']['avatar']) && 
        empty ($this->request->data['User']['fb_id'])) {
        echo $this->Html->link(
          'Change Picture',
          '',
          array(
            'class' => 'btn shift-avatarlink '.$linkClassName,
            'escape' => false,
            'id' => 'changeAvatarLink'
          )
        );
      } else if (empty ($this->request->data['User']['avatar']) && 
          empty ($this->request->data['User']['fb_id'])){
        echo $this->Html->link(
          'Upload Picture',
          '',
          array(
            'class' => 'btn shift-avatarlink '.$linkClassName,
            'escape' => false,
            'id' => 'changeAvatarLink'
          )
        );
      }
      ?>
    </span>  
    <span class="<?php echo $className; ?> avatar-uploader" id='showChangeAvatarDiv'>
      <?php 
      $error = $this->Form->error('filename');
      echo $this->Form->input(
        'filename', 
        array(
          "type" => "file", 
          'label' => array(
            'text' => "Select New Picture" . $error,
            'class' => ''
          ),
          'error' => false
        )
      ); ?>
      <br/>
      <span class="pale-yellow">
        <?php echo __('Please be sure the dimensions of the photo are square, like 100x100, and the file size is less than 1mb.'); ?>
      </span>
    </span>       
  </div>
</div>
