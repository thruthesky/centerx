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


<div class="right-thumbnail-and-texts-2-photo">
  <div class="top">
    <?php include widget('post/right-thumbnail-with-4-stories', ['post' => $primaryPost, 'displayNumber' => true ]); ?>
  </div>
  <div class="bottom">
  <?php include widget('post/two-photos-with-inline-text-at-bottom', $secondStoriesOps); ?>
  </div>
</div>

<style>
  .right-thumbnail-and-texts-2-photo .bottom {
    margin-top: 5px;
  }

</style>