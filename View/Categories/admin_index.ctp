<div id="suggestedPunditsDiv">
  <?php 
  $treeOrganisationArray = array('_', '__', '___', '____', '_____', '______', '_______', '________', '_________'); ?>

  <div class="title_row">
    <h1>Review Dashboard</h1>
  </div><!--end of title_row-->
  <div class="table_holder">
    <div class="table_row">
      <?php echo $this->element('Common/suggested_pundit_tabs'); ?>
      <div class="category_add head_btns">
        <?php  
        echo $this->Html->link(
          __('Add New Category'),
          array(
            'action' => 'add',
            'admin'  => true
          ),
          array(
            'id' => 'CategoryAdd'
          )
        ); 
        ?>
      </div>
    </div><!--end of table_row-->

    
    <table class="table_box admin_table_box">
      <thead>
        <tr>
          <th class="tl"><?php echo __('Categories'); ?></th>
          <th class="tl"><?php echo __('Featured'); ?></th>
          <th class="tl last"><?php echo __('Actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($allCategories as $categoryId => $category) : ?>
            <?php $depth = 0; ?>
            <tr>
              <td style="width:200px;">
                <?php
                for ($i = 0; $i < count($treeOrganisationArray); $i++) {
                  if (substr($category, 0, $i+1) == $treeOrganisationArray[$i]) {
                    $depth = $i + 1;
                  } else {
                      break;
                  }
                }
                if ($depth == 0) {
                  echo escape($category);
                } else {
                  for ($j = 0; $j < $depth; $j++) {
                    echo '<label class="checkbox" style="padding-left:20px !important;margin-bottom:0px;">';
                  }
                  echo escape(substr($category, $depth));
                }
                ?>
                </label>
              </td>
              <td>
                <?php
                  if ($categoriesList[$categoryId] == true) {
                    $flag = 'Yes';
                  } else {
                    $flag = '-';
                  }
                  echo $flag;
                ?>
              </td>
              <td class='span4 last'>
                <?php
                echo $this->Html->link(
                  __('Edit'),
                  array(
                    'action' => 'edit',
                    'admin'  => true,
                    $categoryId
                  ),
                  array(
                    'class' => 'btn_edit',
                    'id' => 'CategoryEdit'
                  )
                );
                echo $this->Form->postLink(
                  __('Remove'), 
                  array(
                    'action' => 'delete',
                    'admin' => true,
                    $categoryId
                  ), 
                  array(
                    'class' => 'btn_deny',
                    'id' => 'CategoryRemove'
                  ), 
                  __('Are you sure you want to delete #%s?', 
                  $categoryId)
                );
                echo $this->Html->link(
                  __('View'),
                  array(
                    'action' => 'view',
                    'admin'  => false,
                    $categoryId
                  ),
                  array(
                    'class' => 'btn_approve'
                  )
                );
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>