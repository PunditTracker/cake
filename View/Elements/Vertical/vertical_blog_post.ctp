<div class="block <?php echo $position; ?>">
  <div class="title_row2">
    <h1>recent blog posts</h1>
    <a href="http://blog.pundittracker.com" class="btn"><span>view all</span></a>
  </div>

  <ul class="recent_posts_list">
    <?php
      $catName = strtolower($categoryName);

      if (!empty($tag)) {
        $tag = strtolower($tag);
      } else {
        $tag = $catName;
      }

      try {
        $xml = @Xml::build('http://blog.pundittracker.com/?feed=rss2&tag='.$tag);
      } catch (Exception $e) {
        $xml = new stdClass();
      }

      if (empty($xml->channel->item)) {
        try {
          $xml = Xml::build('http://blog.pundittracker.com/?feed=rss2');
        } catch(Exception $e) {
          $xml->channel->item = array();
        }
      }
      $i = 0;
      foreach ($xml->channel->item as $item) {
        $i++;
        if ($i == 4) break;
    ?>
    <li>
      <div class="post_title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></div>
      <p><?php echo date('F d, Y', strtotime($item->pubDate)); ?> | <a href="<?php echo 'http://blog.pundittracker.com/?cat='.$item->category ?>"><?php echo strtoupper($catName); ?></a></p>
    </li>
    <?php } ?>
  </ul>
</div><!--end of block-->
