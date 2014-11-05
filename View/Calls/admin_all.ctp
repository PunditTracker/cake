<div id="suggestedPunditsDiv">
<span id='flashMessage' style="display:none;"></span>
  <div class="title_row">
  <h1>Review Dashboard</h1>
  </div><!--end of title_row-->
    <div class="table_holder">
    <div class="table_row">
    <?php echo $this->element('Common/suggested_pundit_tabs'); ?>
    <?php echo $this->element('Common/multi_pagination', array('model' => 'CallDummy')); ?>
    <?php //echo $this->element('Common/pagination'); ?>
    </div><!--end of table_row-->

    <table class="table_box table_box2">
      <tr>
      <th class="col1">Pundit</th>
      <th class="col2">Prediction</th>
      <th class="col3">Link/Source</th>
      <th class="col4">Outcome</th>
      <th class="col4">Featured</th>
      <th class="col4">Approval Date</th>
        <th class="col4">Date Made</th>
        <th class="col4">Vote Untill</th>
        <th class="col5">Date Due</th>
      <th class="last col6">Action</th>
      </tr>
    <?php
    if (empty($calls)) {
    ?>
      <tr>
      <td colspan='10'>No Records found</td>
      </tr>
    <?php
    } else {
      $totalRecords = count($calls);
      foreach ($calls as $key => $prediction) {
        $featured = 'No';
        if ($prediction['CallDummy']['featured']) {
          $featured = 'Yes';
        }
        if (($key % 2) == 0) {
      ?>
          <tr class="odd">
              <td>
                <?php
                echo $this->Html->link(
                  $prediction['User']['first_name'].' '.$prediction['User']['last_name'],
                  array(
                      'controller' => 'pundits',
                      'action' => 'profile',
                      'admin' => false,
                      $prediction['User']['id']
                    ),
                  array()
                );
                ?>
              </td>
          <td><?php echo $prediction['CallDummy']['prediction']; ?><span class="ico_bubble" title="Your vote helps us determine how bold a prediction is, which then feeds into our pundit scoring system"></span></td>
          <td>
            <?php echo $prediction['CallDummy']['source']; ?>
          </td>
          <td>
            <?php
            if (!empty($prediction['CallDummy']['outcome_id'])) {
              echo $outcomes[$prediction['CallDummy']['outcome_id']];
            } else {
              echo '-';
            }
            ?>
          </td>
          <td><?php echo $featured; ?></td>
          <td><?php echo $this->PT->dateFormat($prediction['CallDummy']['approval_time']); ?></td>
        <td><?php echo $this->PT->dateFormat($prediction['CallDummy']['created']); ?></td>
        <td><?php echo $this->PT->dateFormat($prediction['CallDummy']['vote_end_date']); ?></td>
        <td><strong><?php echo  $this->PT->dateFormat($prediction['CallDummy']['due_date']); ?></strong></td>
        <td class="last">
          <?php
                  echo $this->Html->link(
                    __('edit'),
                    array(
                      'admin' => true,
                      'controller' => 'calls',
                      'action' => 'edit',
                      $prediction['CallDummy']['id']
                    ),
                    array(
                      'class' => 'btn_edit editCallSuggestion',
                      'id' => 'editCallSuggestionId'
                    )
                  );
                  ?>
          </td>
        </tr>
          <?php
        } else {
        ?>
        <tr>
        <td>
              <?php
              echo $this->Html->link(
                $prediction['User']['first_name'].' '.$prediction['User']['last_name'],
                array(
                      'controller' => 'pundits',
                      'action' => 'profile',
                      'admin' => false,
                      $prediction['User']['id']
                    ),
                array()
              );
              ?>
            </td>
        <td><?php echo $prediction['CallDummy']['prediction']; ?><span class="ico_bubble" title="Your vote helps us determine how bold a prediction is, which then feeds into our pundit scoring system"></td>
        <td>
            <?php
                echo $this->Html->link(
                  'Link/source',
                  $url,
                  array()
                );
                ?>
          </td>
          <td>
            <?php
            if (!empty($prediction['CallDummy']['outcome_id'])) {
              echo $outcomes[$prediction['CallDummy']['outcome_id']];
            } else {
              echo '-';
            }
            ?>
          </td>
          <td><?php echo $featured; ?></td>
          <td><?php echo $this->PT->dateFormat($prediction['CallDummy']['approval_time']); ?></td>
        <td><?php echo $this->PT->dateFormat($prediction['CallDummy']['created']); ?></td>
        <td><?php echo $this->PT->dateFormat($prediction['CallDummy']['vote_end_date']); ?></td>
        <td><strong><?php echo $this->PT->dateFormat($prediction['CallDummy']['due_date']); ?></strong></td>
        <td class="last">
          <?php
                  echo $this->Html->link(
                    __('edit'),
                    array(
                      'admin' => true,
                      'controller' => 'calls',
                      'action' => 'edit',
                      $prediction['CallDummy']['id']
                    ),
                    array(
                      'class' => 'btn_edit editCallSuggestion',
                      'id' => 'editCallSuggestionId'
                    )
                  );
                  ?>
        </td>
          </tr>
        <?php
      }
        }
    }
    ?>
    </table>
    <div class="table_row">
      <?php //echo $this->element('Common/pagination'); ?>
      <?php echo $this->element('Common/multi_pagination', array('model' => 'CallDummy')); ?>
      <?php echo $this->Js->writeBuffer(); ?>
    </div>
    </div>
</div>
