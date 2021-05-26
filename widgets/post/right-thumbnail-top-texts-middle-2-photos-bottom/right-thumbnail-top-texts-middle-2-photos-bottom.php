<?php

/**
 * @size narrow
 * @options string 'firstCategory', 'secondCategory', 'imageHeight', 'imageWidth'
 * @dependencies none
 */
$op = getWidgetOptions();

$firstCategory = $op['firstCategory'] ?? 'discussion';

if (category($firstCategory)->exists === true) {
  $primaryPost = post()->latest(categoryId: $firstCategory, limit: 1, photo: true);
}

if (!count($primaryPost)) $primaryPost = postMockData(photo: true);
$primaryPost = $primaryPost[0];

$secondStoriesOps = $op;
if (!isset($secondStoriesOps['imageHeight'])) $secondStoriesOps['imageHeight'] = 158;
if (!isset($secondStoriesOps['imageWidth'])) $secondStoriesOps['imageWidth'] = 100;
?>


<div class="right-thumbnail-top-texts-middle-2-photos-bottom">
  <div class="top">
    <?php include widget('post/text-left-thumbnail-right-top-4-texts-bottom', ['post' => $primaryPost, 'displayNumber' => true ]); ?>
  </div>
  <div class="bottom mt-2">
  <?php include widget('post/two-photos-with-inline-text-at-bottom', $secondStoriesOps); ?>
  </div>
</div>