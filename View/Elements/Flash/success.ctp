<div id="flashMessage" class="message div-hide"><?php echo $message; ?></div>
<script type="text/javascript">
setInterval(function () {
  $('#flashMessage.div-hide').fadeOut(1000);
}, 2000);
</script>