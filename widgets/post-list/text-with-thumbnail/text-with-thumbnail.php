<?php

/**
 * @name Text with thumbnail post list
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>

<section class="post-list-text-with-thumbnail px-2 px-lg-0">
  <div class="p-3" style="background-color: #efefef;">
    <?php
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $post = post(idx: $post->idx);
        include widget('post/thumbnail-with-title-and-content', ['post' => $post]);
      }
    } else {
    ?>
      <?php include widget('post-list/no-post-yet'); ?>
    <?php } ?>
  </div>
</section>