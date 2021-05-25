<?php

/**
 * @size wide
 * @options 'categoryId'
 * @dependency none
 */

$o = getWidgetOptions();

$posts = [];

if (isset($o['categoryId'])) {
  $posts = post()->latest($o['categoryId']);
}

$lack = 4 - count($posts);
$posts = array_merge($posts, postMockData($lack, photo: true));

?>

<section class="four-photo-with-title">
  <div class="top">
    <div class="left">
      <?php include widget('post/thumbnail-with-title', ['post' => $posts[0], 'imageHeight' => 55, 'imageWidth' => 90]); ?>
    </div>
    <div class="right">
      <?php include widget('post/thumbnail-with-title', ['post' => $posts[1], 'imageHeight' => 55, 'imageWidth' => 90]); ?>
    </div>
  </div>
  <div class="bottom">
    <div class="left">
      <?php include widget('post/thumbnail-with-title', ['post' => $posts[2], 'imageHeight' => 55, 'imageWidth' => 90]); ?>
    </div>
    <div class="right">
      <?php include widget('post/thumbnail-with-title', ['post' => $posts[3], 'imageHeight' => 55, 'imageWidth' => 90]); ?>
    </div>
  </div>
</section>

<style>
  .four-photo-with-title .top,
  .four-photo-with-title .bottom {
    display: flex;
  }

  .four-photo-with-title .top .left,
  .four-photo-with-title .bottom .left,
  .four-photo-with-title .top .right,
  .four-photo-with-title .bottom .right {
    width: 50%;
  }

  .four-photo-with-title .bottom {
    margin-top: 16px;
  }

  .four-photo-with-title .top .right,
  .four-photo-with-title .bottom .right {
    margin-left: 16px;
  }
</style>