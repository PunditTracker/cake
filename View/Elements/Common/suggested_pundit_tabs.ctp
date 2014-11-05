<?php 
  $suggestedPundit      = '';
  $suggestedPredictions = '';
  $approvedPredictions  = '';
  $allUsers             = '';
  $allCategories        = '';
  if (in_array($this->name, array('SuggestedPundits'))) {
    $suggestedPundit = 'on';
  }
  if (in_array($this->name, array('SuggestedCalls')) && in_array($this->action, array('admin_index'))) {
    $suggestedPredictions = 'on';
  }
  if (in_array($this->name, array('Calls')) && in_array($this->action, array('admin_all'))) {
    $approvedPredictions = 'on';
  }
  if (in_array($this->name, array('Users')) && in_array($this->action, array('admin_index'))) {
    $allUsers = 'on';
  }
  if (in_array($this->name, array('Categories'))) {
    $allCategories = 'on';
  }
?>
<div class="table_btns">
  <?php 
  echo $this->Html->link(
    __('suggested pundits'),
    '',
    array(
      'class' => $suggestedPundit,
      'id' => 'suggestedPunditTab'
    )
  );
  echo $this->Html->link(
    __('suggested predictions'),
    '',
    array(
      'class' => $suggestedPredictions,
      'id' => 'suggestedPredictionTab'
    )
  );
  /*echo $this->Html->link(
    __('All Predictions'),
    '',
    array(
      'class' => $approvedPredictions,
      'id' => 'approvedPredictionTab'
    )
  );*/
  echo $this->Html->link(
    __('All Users'),
    '',
    array(
      'class' => $allUsers,
      'id' => 'adminReviewAllUsersTab'
    )
  );
  echo $this->Html->link(
    __('Categories'),
    '',
    array(
      'class' => $allCategories,
      'id' => 'adminAllCategoriesTab'
    )
  );
  ?>
</div><!--end of table_btns--> 
