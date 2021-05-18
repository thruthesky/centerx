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
  $posts = post()->latest(categoryId: $categoryId, limit: 2);
}

if (empty($posts)) {
  $posts = array_fill(0, 4, null);
}
?>

<div class="four-stories-with-thumbnail">
  <div class="stories">
    <?php
    foreach ($posts as $post) { ?>
      <div class="story">
        <?php include widget('post/photo-with-text-at-bottom', ['post' => $post]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .four-stories-with-thumbnail .stories {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
  }

  .four-stories-with-thumbnail .stories .story {
    width: 50%;
    padding: 2px;
  }
</style>