<?php $option = Configure::read('radio_vote_option'); ?>
<script type="text/javascript">


  $(function(){ 
    parent.$.colorbox.resize({
        width: "550px",
        height: "240px"
    });  
    var content = '<?php 
    	echo $this->Html->link(
    		$option[$this->request->data["Vote"]["rate"]], 
    		"", 
    		array(
    			"escape" => false, 
    			"class" => "editVoteLink", 
    			"id" => "call".$this->request->data["Vote"]["call_id"], 
    			"callId" => $this->request->data["Vote"]["call_id"]
    		)
  		); ?>';

    var selector = "<?php echo 'call'.$this->request->data['Vote']['call_id']; ?>";
   
    parent.$('#' + selector).parents('td').html(content);   
    parent.$.fn.colorbox.close();
    //setTimeout(parent.$.fn.colorbox.close, 5000); 
    
  });

</script>
<!--<div class="submit edit_btns">
<?php
  /*echo $this->Html->link(
    __('Close'),
    '',
    array(
      'class'=>'btn_cancel remove-border ',
      'div' => false,
      'id' => 'closeIframe'
    )
  );*/
?>
</div>-->