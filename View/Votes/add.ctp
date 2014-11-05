<?php //debug($calls);
$category = Configure::read('category_ico');
$options  = Configure::read('radio_vote_option'); ?>
<div class="voteAddFrame" style="margin-left:40px">
    <?php $call = $calls;    
        echo $this->element('Home/live_call',
              array(
                'call'   => $call,
                'options'   => $options,
                'category' => $category
              )
            );           
    ?>
</div>
<script type="text/javascript">

$(function(){
$("select, input:radio").uniform();
});

</script>