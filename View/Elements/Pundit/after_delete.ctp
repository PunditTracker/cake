
<script type="text/javascript">

  $(function(){  
    parent.$.colorbox.resize({
        width: "550px",
        height: "240px"
    });    

    <?php  if (isset($punditDelete) && ($punditDelete)) { ?>      
      parent.window.location = base_url+'users/home';        
    <?php } ?>
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
