<?php

/**
 * @size narrow
 * @options 'title', 'firstCategory', 'secondCategory' 
 * @dependencies none
 */
$op = getWidgetOptions();
?>

<div class="texts-and-4-photo">
  <div class="title">
    <?= (isset($op['title']) && $op['title']) ? $op['title'] : 'This is a sample title.' ?>
  </div>
  <div class="top">
    <?php include widget('post/top-6-stories', ['categoryId' => $op['firstCategory'] ?? null]); ?>
  </div>
  <div class="bottom">
    <?php include widget('post/four-stories-with-thumbnail-inline-text', ['categoryId' => $op['secondCategory'] ?? null]); ?>
  </div>
</div>

<style>
  .texts-and-4-photo .title {
    font-weight: bold;
  }

  .texts-and-4-photo .top,
  .texts-and-4-photo .bottom {
    margin-top: 6px;
  }
</style>