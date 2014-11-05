<div class="page-header">
  <h1>
    <?php echo __('Suggested Pundit'); ?>
    <small></small>
  </h1>
</div>
<?php echo $this->element('Common/suggested_pundit_tabs'); ?>
<table class="table_box">
  <thead>
    <tr>
      <th><?php echo $this->Paginator->sort('pundit_name');?></th>
      <th><?php echo $this->Paginator->sort('category_id');?></th>
      <th class="actions tl"><?php echo __('Actions');?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($SuggestedPundit as $Suggested): ?>
      <tr>
        <td><?php echo escape(h($Suggested['SuggestedPundit']['pundit_name'])); ?></td>
        <td><?php echo escape(h($Suggested['Category']['name'])); ?></td>
        <td class="actions">
          <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $Suggested['SuggestedPundit']['id']), array('class' => 'btn-edit')); ?>
          <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $Suggested['SuggestedPundit']['id']), array('class' => 'btn-delete'), __('Are you sure you want to delete # %s?', $Suggested['SuggestedPundit']['id'])); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


