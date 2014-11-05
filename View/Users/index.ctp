<div class="">
  <h2><?php echo __('Users')?>
  </h2>
  <table class="table table-striped">
  <tr>
    <th><?php echo $this->Paginator->sort('id');?></th>
    <th><?php echo $this->Paginator->sort('first_name');?></th>
    <th><?php echo $this->Paginator->sort('last_name');?></th>
    <th><?php echo $this->Paginator->sort('email');?></th>  
    <th><?php echo $this->Paginator->sort('ARO.parent_id', 'Role');?></th>    
    <th><?php echo $this->Paginator->sort('created');?></th>
    <th><?php echo $this->Paginator->sort('modified');?></th>
    <th class="actions"><?php echo __('Actions');?></th>
  </tr>
  <?php
  foreach ($users as $user): ?>
  <tr>
    <td><?php echo escape(h($user['User']['id'])); ?>&nbsp;</td>
    <td><?php echo escape(h($user['User']['first_name'])); ?>&nbsp;</td>
    <td><?php echo escape(h($user['User']['last_name'])); ?>&nbsp;</td>
    <td><?php echo escape(h($user['User']['email'])); ?>&nbsp;</td>     
    <td><?php echo h((isset($groups[$user['ARO']['parent_id']]) ? $groups[$user['ARO']['parent_id']] : '--')); ?>&nbsp;</td>    
    <td><?php echo h($user['User']['created']); ?>&nbsp;</td>
    <td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
    <td class="actions">
      <?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), array()); ?>
      <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array()); ?>
      <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
       
    </td>
  </tr>
<?php endforeach; ?>
  </table>
  <p>
  <?php
  echo $this->Paginator->counter(array(
  'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
  ));
  ?>  </p>

  <div class="paging">
  <?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
  ?>
  </div>
</div>

<?php echo $this->Html->link('Create new user', array('controller' => 'users', 'action'=>'add'), array('class' => 'btn-large btn-primary btn'))?>
