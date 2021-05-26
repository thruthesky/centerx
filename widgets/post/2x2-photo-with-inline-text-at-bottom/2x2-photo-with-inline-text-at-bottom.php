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
?>

<div class="2x2-photo-with-inline-text">
  <div class="posts d-flex flex-wrap w-100">
    <?php
    foreach ($posts as $post) { ?>
      <div class="post w-50 p-1">
        <?php include widget('post/photo-with-inline-text-at-bottom', [
          'post' => $post,
          'imageHeight' => $op['imageHeight'] ?? 150,
          'imageWidth' => $op['imageWidth'] ?? 100
        ]); ?>
      </div>
    <?php } ?>
  </div>
</div>