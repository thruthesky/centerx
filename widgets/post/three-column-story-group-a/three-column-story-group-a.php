<?php

/**
 * @size wide
 * @options PostTaxonomy $firstPost, PostTaxonomy $secondPost, 'firstCategory' & 'secondCategory' for $rightStories
 * @dependencies none
 */
$op = getWidgetOptions();

?>


<div class="three-column-story-group-a">
  <div class="left">
    <?php include widget('post/photo-with-5-stories', ['post' => $op['firstPost'] ?? firstPost(photo: true)]); ?>
  </div>
  <div class="middle">
    <?php include widget('post/photo-with-3-stories', ['post' => $op['secondPost'] ?? firstPost(photo: true)]); ?>
  </div>
  <div class="right">
    <?php include widget('post/right-thumbnail-and-texts-2-photo', $op['rightStories'] ?? []); ?>
  </div>
</div>

<style>
  .three-column-story-group-a {
    display: flex;
  }

  .three-column-story-group-a .left,
  .three-column-story-group-a .middle,
  .three-column-story-group-a .right {
    display: block;
    width: 33%;
  }

  .three-column-story-group-a .middle {
    margin-left: 8px;
    margin-right: 8px;
  }
</style>