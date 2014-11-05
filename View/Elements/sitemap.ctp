<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
// Some static pages
$sitemap = array(
  array(
    'loc' => Router::url('/', true),
  ),
  array(
    'loc' => Router::url(array('controller' => 'pages', 'action' => 'display', 'about'), true),
  ),
);

$Category = ClassRegistry::init('Category');

// Now get all categories
$categories = $Category->getCategoriesForSitemap();
// Get all the pundits
$pundits = $Category->Pundit->getPunditsForSitemap();
// Get all the users
$users = $Category->Pundit->User->getUsersForSitemap();

$sitemap = array_merge($sitemap, $categories, $pundits, $users);
?>

<?php foreach ($sitemap as $url): ?>
  <url>
    <loc><?php echo $url['loc']; ?></loc>
  </url>
<?php endforeach; ?>
</urlset>