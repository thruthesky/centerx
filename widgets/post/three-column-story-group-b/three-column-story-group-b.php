<?php

/**
 * @size wide
 * @options PostTaxonomy 'post' & 'categoryId' & 'imageHeight' & 'imageWidth' for $firstStories, 'title' & 'firstCategory' & 'secondCategory' & 'imageHeight' & 'imageWidth' for $secondStories
 * @dependencies none
 */
$op = getWidgetOptions();

$secondStoriesOps = $op['secondStories'] ?? [];
if (!isset($secondStoriesOps['imageHeight'])) $secondStoriesOps['imageHeight'] = 90;
if (!isset($secondStoriesOps['imageWidth'])) $secondStoriesOps['imageWidth'] = 90;

$firstStories = $op['firstStories'] ?? [];
?>


<div class="three-column-story-group-b">
  <div class="left">
    <?php include widget('post/two-left-photo-with-stories', $firstStories); ?>
  </div>
  <div class="right">
    <?php include widget('post/texts-and-4-photo', $secondStoriesOps); ?>
  </div>
</div>

<style>
  .three-column-story-group-b {
    display: flex;
    width: 100%;
  }

  .three-column-story-group-b .left {
    width: 60%;
    margin-right: 8px;
  }

  .three-column-story-group-b .right {
    width: 40%;
  }
</style>