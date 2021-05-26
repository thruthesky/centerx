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
  <div class="title mr-2">
    <?= $post->title ?>
  </div>
  <div class="photo">
    <img class="h-100 w-100" src="<?= $src ?>">
  </div>
</a>

<style>
  .title-left-thumbnail-right {
    text-decoration: none;
    color: black;
  }

  .title-left-thumbnail-right .title {
    height: 3em;
  }

  .title-left-thumbnail-right .title {
    width: 70%;
    overflow: hidden;
    font-weight: bold;
  }

  .title-left-thumbnail-right .photo {
    width: 30%;
  }
</style>