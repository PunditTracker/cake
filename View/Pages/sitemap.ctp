<?php
header('Content-Type: application/xml');
echo $this->element('sitemap', array(), array('cache' => array('config' => 'sitemap', 'key' => 'sitemapxml')));
?>