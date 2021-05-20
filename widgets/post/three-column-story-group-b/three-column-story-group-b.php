<?php

/**
 * @size wide
 * @options PostTaxonomy 'post' & 'categoryId' for $firstStories, 'title' & 'firstCategory' & 'secondCategory' for $secondStories
 * @dependencies none
 */
$op = getWidgetOptions();


?>


<div class="three-column-story-group-b">
  <div class="left">
    <?php include widget('post/two-left-photo-with-stories', $op['firstStories'] ?? []); ?>
  </div>
  <div class="right">
    <?php include widget('post/texts-and-4-photo', $op['secondStories'] ?? []); ?>
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