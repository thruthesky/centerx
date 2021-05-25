<?php

/**
 * @size narrow
 * @options 'categoryId', 'imageHeight', 'imageWidth'
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

if (!count($posts)) return;
?>

<div class="widget-2x2-photo-top-text-bottom">
  <div class="stories">
    <?php
    foreach ($posts as $post) { ?>
      <div class="story">
        <?php include widget('post/photo-top-text-bottom', [
          'post' => $post,
          'imageHeight' => $op['imageHeight'] ?? 100,
          'imageWidth' => $op['imageWidth'] ?? null
        ]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .widget-2x2-photo-top-text-bottom .stories {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
  }

  .widget-2x2-photo-top-text-bottom .stories .story {
    width: 50%;
    padding: 2px;
  }

  .widget-2x2-photo-top-text-bottom .stories .story:first-child,
  .widget-2x2-photo-top-text-bottom .stories .story:nth-child(3) {
    padding-right: 6px;
  }

  .widget-2x2-photo-top-text-bottom .stories .story:last-child,
  .widget-2x2-photo-top-text-bottom .stories .story:nth-child(2) {
    padding-left: 6px;
  }
</style>