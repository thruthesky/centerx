<?php

/**
 * @name Text with thumbnail post list
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>

<section class="post-list-text-with-thumbnail px-2 px-lg-0 mb-3">
  <?php
  if (!empty($posts)) {
    foreach ($posts as $post) {
      $post = post(idx: $post->idx);
  ?>
      <div class="p-3 mt-2 rounded" style="background-color: #efefef;">
        <?php include widget('post/thumbnail-left-title-and-content-right', ['post' => $post]); ?>
      </div>
    <?php }
  } else {
    ?>
    <?php include widget('post-list/empty-post-list'); ?>
  <?php } ?>
</section>