<div id="suggestedPunditsDiv">
  <div id='flashMessage' class="hide"></div>
  <div class="title_row">
	 <h1>Review Dashboard</h1>
  </div><!--end of title_row-->
	<div class="table_holder">
		<div class="table_row">
			<?php echo $this->element('Common/suggested_pundit_tabs'); ?>	
			<?php echo $this->element('Common/multi_pagination', array('model' => 'User')); ?>
	  </div><!--end of table_row-->
				
		<table class="table_box admin_table_box">
			<tr>
			  <th class="col1"><?php echo $this->Paginator->sort('User.first_name', 'First Name', array('class' => 'sort_down'));?></th>
			  <th class="col1"><?php echo $this->Paginator->sort('User.last_name', 'Last Name', array('class' => 'sort_down'));?></th>
			  <th class="col3"><?php echo $this->Paginator->sort('User.email', 'Email', array('class' => 'sort_down'));?></th>
			  <th class="col1"><?php echo $this->Paginator->sort('User.score', 'Score', array('class' => 'sort_down'));?></th>
        <th class="col1">
          <?php
          $class = 'sort_down';
          if (!empty($this->request->params['named']['sort']) && (in_array($this->request->params['named']['sort'], array('vote_count')))) {
            $class = 'sort_down '.$this->request->params['named']['direction'];
          }
          echo $this->Paginator->sort('vote_count', 'No. of Votes', array(
            'direction' => ((!empty($this->request->params['named']['direction']) && 'asc' == $this->request->params['named']['direction']) ? 'desc' : 'asc'),
            'class' => $class));
          ?>
        </th>
        <th class="col2">
          <?php
          $class = 'sort_down';
          if (!empty($this->request->params['named']['sort']) && (in_array($this->request->params['named']['sort'], array('votes_graded')))) {
            $class = 'sort_down '.$this->request->params['named']['direction'];
          }
          /*echo $this->Paginator->sort('votes_graded', 'No. of Votes Graded', array(
            'direction' => ((!empty($this->request->params['named']['direction']) && 'asc' == $this->request->params['named']['direction']) ? 'desc' : 'asc'),
            'class' => $class));*/
            echo $this->Paginator->sort('User.calls_graded', 'No. of Votes Graded', array('class' => 'sort_down'));
          ?>
        </th>
			  <th class="last col-action tl">Action</th>
			</tr>
			<?php 
			if (empty ($allUserData)) {
			?>
			  <tr>
				  <td colspan='5' class="noRecord">No Records found</td>
			  </tr>
			<?php
			} else {
			  $totalRecords = count($allUserData);       
			  foreach ($allUserData as $key => $user) {
			    $class = '';
          if (($key % 2) == 0) {
            $class = 'odd';
          } 
			?>
	        <tr class="<?php echo $class; ?>">
					  <td><?php echo $user['User']['first_name']; ?></td>
					  <td><?php echo $user['User']['last_name']; ?></td>
					  <td><?php echo $user['User']['email']; ?></td>
					  <td><?php echo $user['User']['score']; ?></td>
            <td><?php echo $user['0']['vote_count']; ?></td>
            <td>
              <?php 
                //echo $user['0']['votes_graded'];
                echo $user['User']['calls_graded'];
              ?>
            </td>
					  <td class="last">
					  <?php
              echo $this->Html->link(
                __('delete'), 
                '', 
                array(
                  'class' => 'btn_small btn_deny',
                  'id'    => 'deleteUserByAdmin',
                  'userId' => $user['User']['id'],
                  'userName' => $user['User']['first_name'].' '.$user['User']['last_name']
                )
              );
              echo $this->Html->link(
                __('edit'),
                array(
                  'action' => 'edit',
                  'admin'  => true,
                  $user['User']['id']
                ),
                array(                        
                  'class'  => 'btn_edit editUserByAdmin btn_small',
                  'id'     => 'UserAdminEdit',
                  'mobile' => $isMobile
                )
              );
              echo $this->Html->link(
                __('view'),
                array(
                  'action' => 'user_view',
                  'admin'  => true,
                  $user['User']['id']
                ),
                array(                        
                  'class'  => 'btn_approve viewUserByAdmin btn_small',
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
		  <?php echo $this->element('Common/multi_pagination', array('model' => 'User')); ?>
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
