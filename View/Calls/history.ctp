<div class="title_row">
	<h1 id='verticalHistory'><?php echo __('%s history', $categoryName); ?></h1>
	<?php
	if ($this->Session->read('Auth.User.userGroup') == 'Admin') {
      $callSuggestionId = 'suggestCallBoxByAdmin';
    } else {
      $callSuggestionId = 'suggestCallBox';
    }
	echo $this->Html->link(
	  '<span>help us track</span>',
	  '',
	  array(
	    'class' => 'btn',
	    'escape' => false,
	    'id' => $callSuggestionId
	  )
	);
	?>
</div><!--end of title_row-->

<div class="table_holder">
	<div class="table_row">
		<?php 
		$paginationOption = array('model' => 'Call', 'action' => 'history', 'keyId' => $catId);
		echo $this->element('Common/multi_pagination', $paginationOption); ?> 
	</div><!--end of table_row-->
	
	<?php echo $this->element('Call/history_table', array('calls' => $calls)); ?>
	<?php echo $this->Js->writeBuffer(); ?>
	
	<div class="table_row">
		<?php echo $this->element('Common/multi_pagination', $paginationOption); ?> 
	</div><!--end of table_row-->
</div><!--end of table_holder--> 
