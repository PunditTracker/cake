<?php
  echo $this->Html->link('Share this page on Facebook', '#', array('onclick' => 'fbs_click()', 'class' => ''));
?>
<div style="clear:both; padding-top:5px;"></div>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<fb:comments colorscheme="light" href="<?php echo $url;?>" num_posts="5"
  width="660px"></fb:comments>

<script>
  function fbs_click(location_place) {
      // u=location_place;
      u= <?php echo "'".$url."'"; ?>;
      t=document.title;
      window.open(
        'http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),
        'sharer',
        'toolbar=0,status=0,width=426,height=436'
      );
      return false;
  }
</script>
