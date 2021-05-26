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

<div class="6-texts-top-4-photos-bottom">
  <div class="fs-bold">
    <?= (isset($op['title']) && $op['title']) ? $op['title'] : 'This is a sample title.' ?>
  </div>
  <div>
    <?php include widget('post/top-6-post-list', ['categoryId' => $op['firstCategory'] ?? null]); ?>
  </div>
  <div class="mt-3">
    <?php include widget('post/2x2-photo-with-inline-text-at-bottom', $secondStoriesOps); ?>
  </div>
</div>