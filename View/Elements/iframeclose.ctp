<?php $option = Configure::read('radio_vote_option'); ?>
<script type="text/javascript">

  $(function(){  
    parent.$.colorbox.resize({
        width: "550px",
        height: "240px"
    });
    
    if (parent.$("a#punditProfileLiveButton").length > 0 || parent.$("a#punditProfileArchieveButton").length > 0) {
        $.ajax({
          url: base_url + "pundits/pundit_info/<?php echo $this->request->data['User']['id'];?>",  
          cache: true,
          success: function(data) { 
            parent.$(".main_content").empty();
            parent.$(".main_content").html(data);
          }
        });
      
      //parent.$('a.on').trigger('click'); 
    }

    if (parent.$("a#verticalLiveButton").length > 0 || parent.$("a#verticalArchieveButton").length > 0) {
      parent.$('a.on').trigger('click'); 
    }

    if (parent.$("#suggestedPunditsDiv").length > 0) {
      if (parent.$("a.on").length > 0) {
        parent.$('a.on').trigger('click'); 
      }
    }
    setTimeout(parent.$.fn.colorbox.close, 5000);  
    
  });

</script>
<div class="submit edit_btns">
<?php
  echo $this->Html->link(
    __('Close'),
    '',
    array(
      'class'=>'btn_cancel remove-border ',
      'div' => false,
      'id' => 'closeIframe'
    )
  );
?>
</div>
<?php 
/*if (isset($predictionDeleteStatus) && ($predictionDeleteStatus)) {
  echo $this->Html->scriptBlock("parent.location.href = '". $this->Html->url(array('controller' => 'calls', 'action' => 'index', 'admin' => true)) ."';");
}*/
?>