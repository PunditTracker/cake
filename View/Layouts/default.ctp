<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
    <?php
    $title = !empty($title_for_layout) ? $title_for_layout : 'Bringing Accountability to the Prediction Industry';
    if (stripos($title, 'PunditTracker |') !== 0) {
      $title = $title . ', Track Record | PunditTracker';
    }
    echo $title;
    ?>
  </title>
  <?php
  if (empty($metaDescription)) {
    $metaDescription = __('PunditTracker brings accountability to the prediction industry by cataloging and scoring the predictions of pundits in finance, politics, sports &amp; entertainment.');
  }
  echo $this->Html->meta('description', $metaDescription);

  if (!empty($canonicalUrl)) {
    echo '<link rel="canonical" href="' . Router::url($canonicalUrl, true) . '" />';
  }
  ?>
  <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  <?php
    echo $this->fetch('css');
    echo $this->AssetCompress->css('libs.css', Configure::read('asset_compress.options'));
    echo $this->Html->meta('icon');
    echo $this->AssetCompress->script('libs', Configure::read('asset_compress.options'));
  ?>

  <style>
    @media only screen and (max-width: 980px) {
      .primary-nav li.on ul { left: auto; }
    }
  </style>
</head>
<body id="<?php echo @$this->params['controller']; ?>_controller" class="<?php echo @$this->params['action']; ?>_action">
  <div id="ajaxBusy"></div>
  <div id="container">
    <div id="header">
      <?php echo $this->element('Common/header'); ?>
    </div>
    <div id="content">
      <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>

    </div><!--end of content-->
    <div id="footer">
      <?php echo $this->element('Common/footer'); ?>
    </div>
  </div>
  <?php echo $this->element('sql_dump'); ?>
  <?php
    // Array to hold the js file in the site
    echo $this->Html->scriptBlock('var base_url = "'.Router::Url('/', false).'";', array('defer' => true));
    echo $this->Html->scriptBlock('var mobile = "'.$isMobile.'";', array('defer' => true));
    echo $this->AssetCompress->script('plugins', Configure::read('asset_compress.options'));
    echo $this->Html->script('plugins/jquery/jquery.colorbox-min', array('defer' => true));
    echo $this->AssetCompress->script('site', Configure::read('asset_compress.options'));
    echo $this->fetch('script');
    echo $scripts_for_layout;
  ?>

  <script type='text/javascript' defer="defer">
    $(function(){
      $("select, input:radio").uniform();
      // $("input:radio").uniform();
    });

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-27628320-2']);
    _gaq.push(['_setDomainName', 'pundittracker.com']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    var uvOptions = {};
    (function() {
      var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
      uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/UHVj65VLx5t8602PqmOtsg.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
    })();
  </script>

</body>
</html>
