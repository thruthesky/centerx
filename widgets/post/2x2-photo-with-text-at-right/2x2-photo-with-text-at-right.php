<?php

/**
 * @size wide
 * @options 'categoryId'
 * @dependency none
 */

$o = getWidgetOptions();

$posts = [];

if (isset($o['categoryId'])) {
  $posts = post()->latest(categoryId: $o['categoryId']);
}

$lack = 4 - count($posts);
$posts = array_merge($posts, postMockData($lack, photo: true));

if (!count($posts)) return;

?>

<section class="2x2-photo-with-text-at-right d-flex flex-wrap">
  <div class="post w-50 pr-1">
    <?php include widget('post/thumbnail-with-title', ['post' => $posts[0] ?? null, 'imageHeight' => 50, 'imageWidth' => 80]); ?>
  </div>
  <div class="post w-50 pl-1">
    <?php include widget('post/thumbnail-with-title', ['post' => $posts[1] ?? null, 'imageHeight' => 50, 'imageWidth' => 80]); ?>
  </div>
  <div class="post w-50 mt-2 pr-1">
    <?php include widget('post/thumbnail-with-title', ['post' => $posts[2] ?? null, 'imageHeight' => 50, 'imageWidth' => 80]); ?>
  </div>
  <div class="post w-50 mt-2 pl-1">
    <?php include widget('post/thumbnail-with-title', ['post' => $posts[3] ?? null, 'imageHeight' => 50, 'imageWidth' => 80]); ?>
  </div>
</section>