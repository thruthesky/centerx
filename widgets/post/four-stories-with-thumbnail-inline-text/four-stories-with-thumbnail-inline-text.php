<?php

/**
 * @size narrow
 * @options 'categoryId'
 * @dependency none
 */

$op = getWidgetOptions();

$categoryId = 'discussion';
if (isset($op['categoryId'])) {
  $categoryId = $op['categoryId'];
}

$posts = [];
if (category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: 4, photo: true);
}

$lack = 4 - count($posts);
$posts = array_merge($posts, postMockData($lack, photo: true));
?>

<div class="four-stories-with-thumbnail-inline-text">
  <div class="stories">
    <?php
    foreach ($posts as $post) { ?>
      <div class="story">
        <?php include widget('post/photo-with-inline-text-at-bottom', ['post' => $post, 'height' => 100]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .four-stories-with-thumbnail-inline-text .stories {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
  }

  .four-stories-with-thumbnail-inline-text .stories .story {
    width: 50%;
    padding: 2px;
  }
</style>