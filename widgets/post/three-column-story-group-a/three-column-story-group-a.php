<?php

/**
 * @size wide
 * @options PostTaxonomy $firstPost, PostTaxonomy $secondPost, 'firstCategory' & 'secondCategory' for $rightStories
 * @dependencies none
 */
$op = getWidgetOptions();

$firstPost = $op['firstPost'] ?? firstPost(photo: true);
$secondPost = $op['secondPost'] ?? firstPost(photo: true);

$rightStories = $op['rightStories'] ?? [];
?>


<div class="three-column-story-group-a d-flex">
  <div class="left">
    <?php include widget('post/photo-with-5-texts-at-bottom', ['post' => $firstPost ?? firstPost(photo: true)]); ?>
  </div>
  <div class="middle mx-2">
    <?php include widget('post/top-photo-and-3-photo-with-text-right-at-bottom', ['post' => $secondPost ?? firstPost(photo: true)]); ?>
  </div>
  <div class="right">
    <?php include widget('post/right-thumbnail-and-texts-2-photo', $rightStories); ?>
  </div>
</div>

<style>
  .three-column-story-group-a .left,
  .three-column-story-group-a .middle,
  .three-column-story-group-a .right {
    display: block;
    width: 33%;
  }
</style>