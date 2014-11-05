<div id="suggestedPunditsDiv">
  <span id='flashMessage' style="display:none;"></span>
  <div class="title_row">
    <h1>Review Dashboard</h1>
  </div><!--end of title_row-->
  <div class="table_holder">
    <div class="table_row">
      <?php echo $this->element('Common/suggested_pundit_tabs'); ?>
      <?php
      echo $this->element(
        'Common/multi_pagination',
        array(
          'model' => 'Call',
          'action' => 'admin_index'
        )
      );
      ?>
    </div><!--end of table_row-->

    <table class="table_box admin_table_box">
      <tr>
        <th class="col1"><?php echo $this->Paginator->sort('User.first_name', 'Pundit', array('class' => 'sort_down'));?></th>
        <th class="col3"><?php echo $this->Paginator->sort('Call.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
        <th class="col4"><?php echo $this->Paginator->sort('Call.source', 'Link/Source', array('class' => 'sort_down'));?></th>
        <th class="col4"><?php echo $this->Paginator->sort('Call.created', 'Date Made', array('class' => 'sort_down'));?></th>
        <th class="col5"><?php echo $this->Paginator->sort('Call.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
        <th class="last col-action tl">Action</th>
      </tr>
      <?php
      if (empty($calls)) {
      ?>
        <tr>
          <td class="noRecord" colspan='6'>No Records found</td>
        </tr>
      <?php
      } else {
        $totalRecords = count($calls);
        foreach ($calls as $key => $prediction) {
          $class = '';
          if (($key % 2) == 0) {
            $class = 'odd';
          }
        ?>
          <tr class="<?php echo $class; ?>">
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
            <td class="preFirst">
              <?php echo $prediction['Call']['prediction']; ?><span class="ico_bubble" title="Your vote helps us determine how bold a prediction is, which then feeds into our pundit scoring system"></span>
            </td>
            <td>
              <?php echo $prediction['Call']['source']; ?>
            </td>
            <td><?php echo $this->PT->dateFormat($prediction['Call']['created']); ?></td>
            <td><?php echo  $this->PT->dateFormat($prediction['Call']['due_date']); ?></td>
            <td class="last">
              <?php
              echo $this->Html->link(
                __('approve'),
                '',
                array(
                  'class' => 'btn_approve',
                  'id'    => 'approvePredictionButton',
                  'predictionId' => $prediction['Call']['id']
                )
              );
              echo $this->Html->link(
                __('deny'),
                '',
                array(
                  'class' => 'btn_deny',
                  'id'    => 'deletePredictionButton',
                  'predictionId' => $prediction['Call']['id']
                )
              );
              echo $this->Html->link(
                __('edit'),
                array(
                  'admin' => true,
                  'controller' => 'calls',
                  'action' => 'edit',
                  $prediction['Call']['id']
                ),
                array(
                  'class'  => 'btn_edit editCallSuggestion',
                  'id'     => 'editCallSuggestionId',
                  'mobile' => $isMobile
                )
              );
              ?>
            </td>
          </tr>
        <?php
        }
      }
      ?>
    </table>
    <div class="table_row">
      <?php
      echo $this->element(
        'Common/multi_pagination',
        array(
          'model' => 'Call',
          'action' => 'admin_index'
        )
      );
      ?>
      <?php echo $this->Js->writeBuffer(); ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function(){
      selector = $(".asc, .desc").parent("th");
      var index = $(selector).index();
      $("table tr").each(function() {
        $(this).children("td:eq("+index+")").addClass("sort_on");
      });
  });//end jquery ready
</script>