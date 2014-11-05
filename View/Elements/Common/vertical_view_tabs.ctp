<div class="table_btns">
  <?php
  echo $this->Html->link(
    __('live predictions'),
    array(
      'controller' => 'categories',
      'action' => 'view_all_calls',
      $topPundit['Category']['slug'],
    ),
    array(
      'class' => ($selectedTab == 'liveCalls') ? 'on' : '',
      'id' => 'verticalLiveButton',
      'categoryId' => $categoryId
    )
  );
  echo $this->Html->link(
    __('past predictions'),
    array(
      'controller' => 'categories',
      'action' => 'view_all_calls',
      $topPundit['Category']['slug'],
      'archive' => true,
    ),
    array(
      'class' =>  ($selectedTab == 'archiveCalls') ? 'on' : '',
      'id' => 'verticalArchieveButton',
      'categoryId' => $categoryId
    )
  );
  ?>
</div><!--end of table_btns-->

