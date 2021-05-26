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
  <div class="fs-bold">
    <?= (isset($op['title']) && $op['title']) ? $op['title'] : 'This is a sample title.' ?>
  </div>
  <div>
    <?php include widget('post/top-6-stories', ['categoryId' => $op['firstCategory'] ?? null]); ?>
  </div>
  <div class="mt-3">
    <?php include widget('post/2x2-photo-with-inline-text-at-bottom', $secondStoriesOps); ?>
  </div>
</div>