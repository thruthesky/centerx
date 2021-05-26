<?php

/**
 * @size wide
 * @options 'title', 'firstCategoryId', 'secondCategoryId', 'imageHeight', 'imageWidth'
 * @dependency none
 */

$op = getWidgetOptions();

$title = $op['title'] ?? 'This is a sample title';
$imageHeight = $op['imageHeight'] ?? 150;
$imageWidth = $op['imageWidth'] ?? 150;
?>


<div class="photo-left-texts-right-top-4-photos-bottom">
  <h5 class="text-center">
    <?= $title ?>
  </h4>

  <div class="first-story">
    <?php include widget('post/photo-left-texts-right', ['categoryId' => $op['firstCategoryId'] ?? null]); ?>
  </div>

  <div class="posts d-flex mt-2 w-100">
    <?php
    if (isset($op['secondCategoryId'])) {
      $posts = post()->latest(categoryId: $op['secondCategoryId'], limit: 4);
    } else {
      $posts = postMockData(4, photo: true);
    }


    for ($i = 0; $i < count($posts); $i++) {
    ?>
      <div class="post w-25 post-<?= $i ?>">
        <?php include widget('post/photo-top-text-bottom', [
          'post' => $posts[$i],
          'imageHeight' => $imageHeight,
          'imageWidth' => $imageWidth
        ]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .photo-left-texts-right-top-4-photos-bottom .posts .post-1 {
    margin-right: 4px;
    margin-left: 8px;
  }

  .photo-left-texts-right-top-4-photos-bottom .posts .post-2 {
    margin-right: 8px;
    margin-left: 4px;
  }
</style>