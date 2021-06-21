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
    <?php include widget('post/photo-top-texts-bottom', ['post' => $firstPost ?? firstPost(photo: true)]); ?>
  </div>
  <div class="middle mx-2">
    <?php include widget('post/photo-top-photo-with-text-bottom', ['post' => $secondPost ?? firstPost(photo: true)]); ?>
  </div>
  <div class="right">
    <?php include widget('post/right-thumbnail-top-texts-middle-2-photos-bottom', $rightStories); ?>
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