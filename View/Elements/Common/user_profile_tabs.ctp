<div class="table_btns">
  <?php
  echo $this->Html->link(
    __('live predictions'),
    array(
      'controller' => 'users',
      'action' => 'profile_calls',
      $currentUserData['User']['slug'],
    ),
    array(
      'class' => ($selectedTab == 'liveCalls') ? 'on' : '',
      'id' => 'userProfileLiveButton',
      'userId' => $userId
    )
  );
  echo $this->Html->link(
    __('past predictions'),
    array(
      'controller' => 'users',
      'action' => 'profile_calls',
      $currentUserData['User']['slug'],
      'archive' => true,
    ),
    array(
      'class' => ($selectedTab == 'archiveCalls') ? 'on' : '',
      'id' => 'userProfileArchieveButton',
      'userId' => $userId
    )
  );
  ?>
</div><!--end of table_btns-->

