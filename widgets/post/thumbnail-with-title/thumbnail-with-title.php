<?php

/**
 * @size narrow
 * @options PostTaxonomy 'post', 'imageHeight', 'imageWidth'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);


$imageHeight = $op['imageHeight'] ?? 200;
$imageWidth = $op['imageWidth'] ?? 280;
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, height: $imageHeight, width: $imageWidth);
$url = $post->url;
?>

<a class="thumbnail-with-title" href="<?= $url ?>">
  <div class="photo" style="height: <?= $imageHeight ?>; width: <?= $imageWidth ?>;">
    <img src="<?= $src ?>">
  </div>
  <div class="title">
    <?= $post->title ?>
  </div>
</a>

<style>
  .thumbnail-with-title {
    display: flex;
    width: 100%;
    height: 3em;
    overflow: hidden;
  }

  .thumbnail-with-title .title {
    display: block;
    margin-left: 8px;
    width: 70%;
    font-weight: bold;
    font-size: 1em;
  }

  .thumbnail-with-title .photo img {
    display: block;
    width: 100%;
    height: 100%;
  }
</style>