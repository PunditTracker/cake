<div id="suggestedPunditsDiv">
  <div id='flashMessage' class="hide"></div>
  <div class="title_row">
    <h1>Review Dashboard</h1>
  </div><!--end of title_row-->
  <div class="table_holder">
    <div class="table_row">
      <?php
      echo $this->element('Common/suggested_pundit_tabs');
      echo $this->element('Common/multi_pagination', array('model' => 'SuggestedPundit'));
      ?>
    </div><!--end of table_row-->

    <table class="table_box admin_table_box">
      <tr>
        <th class="col1"><?php echo $this->Paginator->sort('SuggestedPundit.pundit_name', 'Pundit', array('class' => 'sort_down'));?></th>
        <th class="col3"><?php echo $this->Paginator->sort('Category.name', 'Category', array('class' => 'sort_down'));?></th>
        <th class="col4"><?php echo $this->Paginator->sort('User.first_name', 'Suggested By', array('class' => 'sort_down'));?></th>
        <th class="col4"><?php echo $this->Paginator->sort('SuggestedPundit.created', 'Suggested On', array('class' => 'sort_down'));?></th>
        <th class="last col-action tl">Action</th>
      </tr>
      <?php
      if (empty ($allSuggestedPundits)) { ?>
        <tr>
          <td class="noRecord" colspan='5'>No Records found</td>
        </tr>
      <?php
      } else {
        $totalRecords = count($allSuggestedPundits);
        foreach ($allSuggestedPundits as $key => $pundit) {
          $class = '';
          if (($key % 2) == 0) {
            $class = 'odd';
          }
      ?>
          <tr class="<?php echo $class; ?>">
            <td><?php echo $pundit['SuggestedPundit']['pundit_name']; ?></td>
            <td><?php echo $pundit['Category']['name']; ?></td>
            <td><?php echo $pundit['User']['first_name'].' '.$pundit['User']['last_name']; ?></td>
            <td><?php echo $this->PT->dateFormat($pundit['SuggestedPundit']['created']); ?></td>
            <td class="last">
              <?php
              echo $this->Html->link(
                __('approve'),
                '',
                array(
                  'class' => 'btn_approve',
                  'id' => 'approveSuggestedButton',
                  'suggestionId' => $pundit['SuggestedPundit']['id']
                )
              );
              echo $this->Html->link(
                __('deny'),
                '',
                array(
                  'class' => 'btn_deny',
                  'id'    => 'deleteSuggestionButton',
                  'suggestionId' => $pundit['SuggestedPundit']['id'],
                  'punditName' => $pundit['SuggestedPundit']['pundit_name']
                )
              );
              echo $this->Html->link(
                __('edit'),
                array(
                  'action' => 'edit',
                  'admin'  => true,
                  $pundit['SuggestedPundit']['id']
                ),
                array(
                  'class'  => 'btn_edit editPunditSuggestion',
                  'id'     => 'editPunditSuggestionLinkId',
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
      echo $this->element('Common/multi_pagination', array('model' => 'SuggestedPundit'));
      echo $this->Js->writeBuffer(); ?>
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