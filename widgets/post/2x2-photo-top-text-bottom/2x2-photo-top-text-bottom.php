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
  <div class="posts row">
    <?php
    foreach ($posts as $post) { ?>
      <div class="post col-6">
        <?php include widget('post/photo-top-text-bottom', [
          'post' => $post,
          'imageHeight' => $op['imageHeight'] ?? 100,
          'imageWidth' => $op['imageWidth'] ?? null
        ]); ?>
      </div>
    <?php } ?>
  </div>
</div>
