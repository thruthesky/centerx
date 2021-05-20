<?php

/**
 * @size wide
 * @options string 'firstCategory', 'secondCategory', 'thirdCategory'
 * @dependencies none
 * @description 
 */
$op = getWidgetOptions();


?>


<div class="three-column-story-group">
  <div class="left">
    <?php include widget('post/photo-with-5-stories', ['post' => null]); ?>
  </div>
  <div class="middle">
    <?php include widget('post/photo-with-3-stories', ['post' => null]); ?>
  </div>
  <div class="right">
    <?php include widget('post/right-thumbnail-and-texts-2-photo', ['firstCategory' => null, 'secondCategory' => null]); ?>
  </div>
</div>

<style>
  .three-column-story-group {
    display: flex;
  }

  .three-column-story-group .left,
  .three-column-story-group .middle,
  .three-column-story-group .right {
    display: block;
    width: 33%;
  }

  .three-column-story-group .middle {
    margin-left: 8px;
    margin-right: 8px;
  }
</style>