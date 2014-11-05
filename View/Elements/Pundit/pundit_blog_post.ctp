<div class="block <?php echo $position; ?>">
  <div class="title_row2">
    <h1>recent blog posts</h1>
    <a href="http://blog.pundittracker.com" class="btn"><span>view all</span></a>
  </div>

  <ul class="recent_posts_list">
    <?php
      $punditName = str_replace(' ', '-', strtolower(rtrim($punditName)));

      try {
        $xml = @Xml::build("http://blog.pundittracker.com/tag/$punditName/feed/");
      } catch (Exception $e) {
          $xml = null;
      }

      if (empty($xml->channel->item)) {
        $xml = Xml::build('http://blog.pundittracker.com/?feed=rss2');
      }
      $i = 0;
      foreach ($xml->channel->item as $item) {
        $i++;
        if ($i == 4) break;
    ?>
    <li>
      <div class="post_title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></div>
      <p>
        <?php echo date('F d, Y', strtotime($item->pubDate)); ?> | <a href="<?php echo 'http://blog.pundittracker.com/?tag='.$item->category ?>"><?php echo strtoupper($item->category); ?></a>
      </p>
    </li>
    <?php } ?>
  </ul>
</div><!--end of block-->
