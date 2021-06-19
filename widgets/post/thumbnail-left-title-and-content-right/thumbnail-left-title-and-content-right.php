<?php

/**
 * @size wide
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost();

$imageHeight = $op['imageHeight'] ?? 200;
$imageWidth = $op['imageWidth'] ?? 300;

$src = '';
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, height: $imageHeight, width: $imageWidth);
$url = $post->url;
?>

<a class="thumbnail-left-title-and-content-right" href="<?= $url ?>" style="height: <?= $imageHeight ?>px">
  <?php if ($src) { ?>
    <img class="mr-3 rounded" class="photo" src="<?= $src ?>">
  <?php } ?>
  <div class="title-content">
    <div class="title font-weight-bold">
      <?= $post->title ?>
    </div>
    <div class="content">
      <?= $post->content ?>
    </div>
  </div>
</a>

<style>
  .thumbnail-left-title-and-content-right {
    display: flex;
    max-height: 6em;
    width: 100%;
    text-decoration: none;
    color: black;
  }

  .thumbnail-left-title-and-content-right .meta {
    display: block;
    margin-left: 15px;
    min-width: 90px;
    text-align: right;
  }

  .thumbnail-left-title-and-content-right .title-content {
    height: 100%;
    width: 100%;
    overflow: hidden;
  }


  .thumbnail-left-title-and-content-right .title-content .title {
    overflow: hidden;
  }

  .thumbnail-left-title-and-content-right .title-content .title,
  .thumbnail-left-title-and-content-right .title-content .content {
    height: 3em;
  }
</style>