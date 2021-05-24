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

<a class="right-thumbnail-with-title" href="<?= $url ?>" style="height: <?= $imageHeight ?>px;">
  <div class="title">
    <?= $post->title ?>
  </div>
  <div class="photo">
    <img src="<?= $src ?>">
  </div>
</a>

<style>
  .right-thumbnail-with-title {
    display: flex;
    width: 100%;
    text-decoration: none;
    color: black;
  }

  .right-thumbnail-with-title .title {
    height: 3em;
  }

  .right-thumbnail-with-title .title {
    width: 70%;
    margin-right: 8px;
    overflow: hidden;
    font-weight: bold;
  }

  .right-thumbnail-with-title .photo {
    width: 30%;
  }

  .right-thumbnail-with-title .photo img {
    height: 100%;
    width: 100%;
  }
</style>