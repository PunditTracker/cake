<div class="head_btns" style="margin-bottom:10px;">
<?php  
  echo $this->Html->link(
    __('Add New Outcome'),
    array(
      'action' => 'add',
      'admin'  => true
    )
  ); ?>
</div>
<table class="table_box admin_table_box">
    <thead>
      <tr>
        <th><?php echo __('Title'); ?></th>
        <th><?php echo __('Rating'); ?></th>
        <th><?php echo __('Actions'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($allOutcomes as $outcome) : ?>
        <tr>
          <td><?php echo $outcome['Outcome']['title']; ?></td>
          <td><?php echo $outcome['Outcome']['rating']; ?></td>
          <td>
            <?php
              echo $this->Html->link(
                __('Edit'),
                array(
                  'action' => 'edit',
                  'admin'  => true,
                  $outcome['Outcome']['id']
                ),
                array(
                  'class' => 'btn_edit'
                )
              );
              echo $this->Form->postLink(
                __('Remove'), 
                array(
                  'action' => 'delete',
                  'admin' => true,
                  $outcome['Outcome']['id']
                ), 
                array(
                  'class' => 'btn_deny'
                ), 
                __('Are you sure you want to delete #%s?', 
                $outcome['Outcome']['id'])
              );
              ?>
          </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
