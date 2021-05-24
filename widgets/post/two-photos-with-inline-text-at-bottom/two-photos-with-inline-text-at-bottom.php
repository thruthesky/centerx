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


<div class="two-photos-with-inline-text-at-bottom">
  <div class="left-story">
    <?php include widget('post/photo-with-inline-text-at-bottom', [
      'post' => $posts[0],
      'imageHeight' => $imageHeight,
      'imageWidth' => $imageWidth
    ]); ?>
  </div>
  <div class="right-story">
    <?php include widget('post/photo-with-inline-text-at-bottom', [
      'post' => $posts[1],
      'imageHeight' => $imageHeight,
      'imageWidth' => $imageWidth
    ]); ?>
  </div>
</div>

<style>
  .two-photos-with-inline-text-at-bottom {
    display: flex;
    width: 100%;
  }

  .two-photos-with-inline-text-at-bottom .right-story {
    margin-left: 8px;
  }

  .two-photos-with-inline-text-at-bottom .right-story,
  .two-photos-with-inline-text-at-bottom .left-story {
    width: 50%;
    height: 100%;
  }
</style>