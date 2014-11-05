<div class="table_btns">
  <?php
  echo $this->Html->link(
    __('live predictions'),
    array(
      'controller' => 'pundits',
      'action' => 'profile_calls',
      $userInfo['User']['slug'],
    ),
    array(
      'class' => ($selectedTab == 'liveCalls') ? 'on' : '',
      'id' => 'punditProfileLiveButton',
      'punditId' => $punditId
    )
  );
  echo $this->Html->link(
    __('past predictions'),
    array(
      'controller' => 'pundits',
      'action' => 'profile_calls',
      $userInfo['User']['slug'],
      'archive' => true,
    ),
    array(
      'class' =>  ($selectedTab == 'archiveCalls') ? 'on' : '',
      'id' => 'punditProfileArchieveButton',
      'punditId' => $punditId
    )
  );
  ?>
</div><!--end of table_btns-->

