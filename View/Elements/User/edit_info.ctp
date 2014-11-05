<script type="text/javascript">

  $(function(){    
  
    parent.$.colorbox.resize({
      width: "550px",
      height: "240px"
    });

    $.ajax({
      url: base_url + "users/user_info",  
      cache: true,
      success: function(data) { 
        parent.$(".main_content").empty();
        parent.$(".main_content").html(data);
      }
    });

    //parent.$('#userProfileLiveButton').trigger('click');   
    setTimeout(parent.$.fn.colorbox.close, 2000);  
    
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