<?php

/**
 * @size wide
 * @options string 'categoryId', 'imageHeight', 'imageWidth'
 * @dependency none
 * @description Displays 2 post side by side, each containing photo with inline text. It uses 'photo-with-inline-text-at-bottom' widget as child.
 */
$op = getWidgetOptions();


$categoryId = 'qna';
if (isset($op['categoryId'])) {
  $categoryId = $op['categoryId'];
}

$posts = [];
if (category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: 2, photo: true);
}

$lack = 2 - count($posts);
$posts = array_merge($posts, postMockData($lack, photo: true));

$imageHeight =  $op['imageHeight'] ?? 150;
$imageWidth = $op['imageWidth'] ?? 250;
?>


<div class="two-photos-with-inline-text-at-bottom d-flex w-100">
  <div class="left-story w-50 h-100">
    <?php include widget('post/photo-with-inline-text-at-bottom', [
      'post' => $posts[0],
      'imageHeight' => $imageHeight,
      'imageWidth' => $imageWidth
    ]); ?>
  </div>
  <div class="right-story w-50 h-100 ml-3">
    <?php include widget('post/photo-with-inline-text-at-bottom', [
      'post' => $posts[1],
      'imageHeight' => $imageHeight,
      'imageWidth' => $imageWidth
    ]); ?>
  </div>
</div>
