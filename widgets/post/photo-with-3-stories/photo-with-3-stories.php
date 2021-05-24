<?php


/**
 * @size narrow
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);
$posts = post()->latest(categoryIdx: $post->categoryIdx, limit: 3, photo: true);
?>

<div class="photo-with-3-story-list">
  <div class="top">
    <?php include widget('post/photo-with-inline-text-at-bottom', [
      'post' => $post,
      'imageHeight' => 160,
      'imageWidth' => 160
    ]); ?>
  </div>
  <div class="list">
    <?php foreach ($posts as $post) { ?>
      <div class="story">
        <?php include widget('post/thumbnail-with-title', [
          'post' => $post,
          'imageHeight' => 50,
          'imageWidth' => 75
        ]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .photo-with-3-story-list {
    display: block;
  }

  .photo-with-3-story-list .list .story {
    margin-top: 8px;
  }
</style>