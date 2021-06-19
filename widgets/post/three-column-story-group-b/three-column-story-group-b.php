<?php

/**
 * @size wide
 * @options PostTaxonomy 'post' & 'categoryId' & 'imageHeight' & 'imageWidth' for $firstStories, 'title' & 'firstCategory' & 'secondCategory' & 'imageHeight' & 'imageWidth' for $secondStories
 * @dependencies none
 */
$op = getWidgetOptions();

$firstStories = $op['firstStories'] ?? [];

$secondStoriesOps = $op['secondStories'] ?? [];
if (!isset($secondStoriesOps['imageHeight'])) $secondStoriesOps['imageHeight'] = 90;
if (!isset($secondStoriesOps['imageWidth'])) $secondStoriesOps['imageWidth'] = 90;

?>


<div class="three-column-story-group-b">
  <div class="left mr-2">
    <?php include widget('post/two-left-photo-with-stories', $firstStories); ?>
  </div>
  <div class="right">
    <?php include widget('post/6-texts-top-4-photos-bottom', $secondStoriesOps); ?>
  </div>
</div>

<style>
  .three-column-story-group-b {
    display: flex;
    width: 100%;
  }

  .three-column-story-group-b .left {
    width: 60%;
  }

  .three-column-story-group-b .right {
    width: 40%;
  }
</style>