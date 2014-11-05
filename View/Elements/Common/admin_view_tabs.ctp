<?php 
  $liveCalls = '';
  $archieves = ''; 
  if ($selectedTab == 'liveCalls') {
    $liveCalls = 'on';
  }
  if ($selectedTab == 'archieves') {
    $archieves = 'on';
  }
?>
<div class="table_btns">
  <?php 
  echo $this->Html->link(
    __('live predictions'),
    array(
      'controller' => 'categories',
      'action' => 'view',
      'admin'  => true
    ),
    array(
      'class' => $liveCalls
    )
  );
  echo $this->Html->link(
    __('archive'),
    array(
      'controller' => 'categories',
      'action' => 'view/archieve',
      'admin' => true
    ),
    array(
      'class' => $archieves
    )
  );
  ?>
</div><!--end of table_btns--> 

