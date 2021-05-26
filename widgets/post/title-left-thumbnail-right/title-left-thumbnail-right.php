<?php

/**
 * @size wide
 * @options PostTaxonomy $post, 'imageHeight', 'imageWidth'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);

$imageHeight = $op['imageHeight'] ?? 100;
$imageWidth = $op['imageWidth'] ?? 150;
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, height: $imageHeight, width: $imageWidth);
$url = $post->url;
?>

<a class="title-left-thumbnail-right d-flex w-100" href="<?= $url ?>" style="height: <?= $imageHeight ?>px;">
  <div class="title mr-2 font-weight-bold">
    <?= $post->title ?>
  </div>
  <img class="photo rounded h-100" src="<?= $src ?>">
</a>

<style>
  .title-left-thumbnail-right {
    text-decoration: none;
    color: black;
  }

  .title-left-thumbnail-right .title {
    height: 3em;
    width: 70%;
    overflow: hidden;
  }

  .title-left-thumbnail-right .photo {
    width: 30%;
  }
</style>