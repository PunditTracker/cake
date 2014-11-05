<table class="table_box admin_table_box">
  <tr>
    <th class="col1">Pundit</th>
	<th class="col2">Prediction</th>
	<th class="col3">Date Made</th>
	<th class="col4">Date Due</th>
	<th class="col5">Outcome</th>
	<th class="col6">Vote Until</th>
	<th class="col7"><span>Source</span></th>
	<th class="last col8">My Vote</th>
	</tr>
	<?php
	if (empty($allCallsData)) {
	?>
    <tr>
        <td class="noRecord" colspan='8'>No Records found</td>
    </tr>
  <?php
  } else { 
    $newCallsArray = array();
    foreach ($allCallsData as $key => $category) {
	    if (count($category['Call']) > 0) {
		  foreach ($category['Call'] as $call) {
		    $newCallsArray[] = $call;
		  }
		}
  } 
  if (empty($newCallsArray)) { ?>
	  <tr>
      <td colspan='8'>No Records found</td>
    </tr>
  <?php
  } 
  foreach ($newCallsArray as $key => $call) {
		if (($key % 2) == 0) {
	?>
      <tr class="odd">
				<td>
				  <?php 
				  echo $this->Html->link(
				    $call['User']['first_name'].' '.$call['User']['last_name'], 
				    '', 
				    array()
				  ); 
				  ?>
				</td>
				<td><?php echo $call['prediction']; ?></td>
				<td class="td_center"><?php echo $this->PT->dateFormat($call['created']); ?></td>
				<td class="td_center"><?php echo $this->PT->dateFormat($call['due_date']); ?></td>
				<td class="td_center">TBD</td>
				<td class="td_center"><?php echo $this->PT->dateFormat($call['vote_end_date']); ?></td>
				<td class="td_center"><?php echo $call['source']; ?></td>
				<td class="td_center last">
				  <?php echo $this->Html->link('VOTE NOW', '', array('class' => "btn_vote_now")); ?>
				</td>
		  </tr>
   	<?php    
    } else { ?>
      <tr>
				<td>
				  <?php 
				  echo $this->Html->link(
				    $call['User']['first_name'].' '.$call['User']['last_name'], 
				    '', 
				    array()
				  ); 
				  ?>
				</td>
				<td><?php echo $call['prediction']; ?></td>
				<td class="td_center"><?php echo $this->PT->dateFormat($call['created']); ?></td>
				<td class="td_center"><?php echo $this->PT->dateFormat($call['due_date']); ?></td>
				<td class="td_center">echo $this->Html->image('tbd.png', array('alt' => 'TBD'));</td>
				<td class="td_center"><?php echo $this->PT->dateFormat($call['vote_end_date']); ?></td>
				<td class="td_center"><?php echo $call['source']; ?></td>
				<td class="td_center last">
				  <?php echo $this->Html->link('VOTE NOW', '', array('class' => "btn_vote_now")); ?>
				</td>
		  </tr>  
    <?php 
      }
    }
  } 
  ?>		
</table>
