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
          'model' => 'SuggestedCall',
          'action' => 'admin_index'
        )
      );
      ?>
    </div><!--end of table_row-->

    <table class="table_box admin_table_box">
      <tr>
        <th class="col1"><?php echo $this->Paginator->sort('SuggestedCall', 'Pundit_name', array('class' => 'sort_down'));?></th>
        <th class="col3"><?php echo $this->Paginator->sort('SuggestedCall.prediction', 'Prediction', array('class' => 'sort_down'));?></th>
        <th class="col4"><?php echo $this->Paginator->sort('SuggestedCall.source', 'Link/Source', array('class' => 'sort_down'));?></th>
        <th class="col4"><?php echo $this->Paginator->sort('SuggestedCall.created', 'Date Made', array('class' => 'sort_down'));?></th>
        <th class="col5"><?php echo $this->Paginator->sort('SuggestedCall.due_date', 'Date Due', array('class' => 'sort_down'));?></th>
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
             /* echo $this->Html->link(
                $prediction['SuggestedCall']['pundit_name'].' '.$prediction['User']['last_name'],
                array(
                  'controller' => 'pundits',
                  'action' => 'profile',
                  'admin' => false,
                  $prediction['User']['id']
                ),
                array()
              );*/
              echo $prediction['SuggestedCall']['pundit_name'];
              ?>
            </td>
            <td class="preFirst">
              <?php echo $prediction['SuggestedCall']['prediction']; ?><span class="ico_bubble" title="Your vote helps us determine how bold a prediction is, which then feeds into our pundit scoring system"></span>
            </td>
            <td>
              <?php echo $prediction['SuggestedCall']['source']; ?>
            </td>
            <td><?php echo $this->PT->dateFormat($prediction['SuggestedCall']['created']); ?></td>
            <td><?php echo  $this->PT->dateFormat($prediction['SuggestedCall']['due_date']); ?></td>
            <td class="last">
              <?php
              /*echo $this->Html->link(
                __('approve'),
                '',
                array(
                  'class' => 'btn_approve approvePredictionButton',
                  'id'    => $prediction['SuggestedCall']['id'],
                )
              );*/
              echo $this->Html->link(
                __('deny'),
                '',
                array(
                  'class' => 'btn_deny',
                  'id'    => 'deletePredictionButton',
                  'predictionId' => $prediction['SuggestedCall']['id']
                )
              );
              echo $this->Html->link(
                __('edit/approve'),
                array(
                  'admin' => true,
                  'controller' => 'SuggestedCalls',
                  'action' => 'edit',
                  $prediction['SuggestedCall']['id']
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
          'model' => 'SuggestedCall',
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