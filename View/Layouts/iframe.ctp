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
   
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>        
  
  <?php
    echo $this->Html->meta('icon');

    echo $this->fetch('css');

    echo $this->AssetCompress->css('libs.css', Configure::read('asset_compress.options'));
    echo $this->AssetCompress->css('iframe.css', Configure::read('asset_compress.options'));  
        // Array to hold the js file in the site
    echo $this->Html->scriptBlock('var base_url = "'.Router::Url('/', false).'";');
    echo $this->Html->scriptBlock('var mobile = "'.$isMobile.'";');
    echo $this->AssetCompress->script('libs', Configure::read('asset_compress.options'));
 
      
  ?>
  <script type='text/javascript'>
    $(function(){
      $("select, input:radio").uniform();
    });
  </script>
</head>
<body>
  <div id="ajaxBusy"></div>
  <div id="container">     
    <div id="cboxContent" class="cboxIframe">    
    <?php
     $sessionFlashMsg = $this->Session->flash();
     $class = ''; 
     if ($sessionFlashMsg) { 
      $class = 'flashMsgPosition';
      ?><div class="beforeFlashMessageDiv"></div><?php
     }
     ?>
      <div class="<?php echo $class;?>">
        <?php echo $sessionFlashMsg; ?>
      </div>
        <?php echo $content_for_layout; ?>
    </div><!--end of content--> 
     
  </div>
  <?php  

  echo $this->AssetCompress->script('plugins', Configure::read('asset_compress.options'));
  
  echo $this->Html->script('plugins/jquery/jquery.colorbox-min');
  echo $this->AssetCompress->script('site', Configure::read('asset_compress.options'));

  echo $this->AssetCompress->script('iframe', Configure::read('asset_compress.options'));

  echo $this->fetch('script');

  echo $scripts_for_layout;

  ?>
  <?php //echo $this->element('sql_dump'); ?>
</body>


</html>
