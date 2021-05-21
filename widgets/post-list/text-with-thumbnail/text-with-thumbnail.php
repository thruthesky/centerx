<?php

/**
 * @name Text with thumbnail post list
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>

<section class="post-list-default px-2 px-lg-0">
  <div style="padding: 1rem 1rem 0 1rem; background-color: #efefef;">
    <?php
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $post = post(idx: $post->idx);
        include widget('post/thumbnail-with-title-and-content', ['post' => $post]);
      }
    } else {
    ?> <div class="pb-3 d-flex justify-content-center">No posts yet ..</div>
    <?php } ?>
  </div>
</section>