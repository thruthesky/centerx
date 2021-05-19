<?php


/**
 * @size wide
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost();
$posts = post()->latest(categoryIdx: $post->categoryIdx, limit: 3);
?>

<div class="photo-with-3-story-list">
  <div class="top">
    <?php include widget('post/photo-with-inline-text-at-bottom', ['post' => $post]); ?>
  </div>
  <div class="list">
    <?php foreach ($posts as $post) { ?>
      <div class="story">
        <?php include widget('post/thumbnail-with-title', ['post' => $post]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>

    .photo-with-3-story-list .list .story {
      margin-top: 8px;
    }

</style>