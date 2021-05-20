<?php

/**
 * @size narrow
 * @options 'title', 'firstCategory', 'secondCategory', 'imageHeight', 'imageWidth'
 * @dependencies none
 */
$op = getWidgetOptions();

$secondStoriesOps = [
  'categoryId' => $op['secondCategory'] ?? null,
  'imageHeight' => $op['imageHeight'] ?? 100,
  'imageWidth' => $op['imageWidth'] ?? 100
];
?>

<div class="texts-and-4-photo">
  <div class="title">
    <?= (isset($op['title']) && $op['title']) ? $op['title'] : 'This is a sample title.' ?>
  </div>
  <div class="top">
    <?php include widget('post/top-6-stories', ['categoryId' => $op['firstCategory'] ?? null]); ?>
  </div>
  <div class="bottom">
    <?php include widget('post/four-stories-with-thumbnail-inline-text', $secondStoriesOps); ?>
  </div>
</div>

<style>
  .texts-and-4-photo .title {
    font-weight: bold;
  }

  .texts-and-4-photo .top {
    margin-top: 4px;
  }
  .texts-and-4-photo .bottom {
    margin-top: 2px;
  }
</style>