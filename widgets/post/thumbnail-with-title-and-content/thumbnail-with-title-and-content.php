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

<div class="thumbnail-with-title-and-content">
  <a class="body" href="<?= $url ?>">
    <?php if ($src) { ?>
      <img class="photo" src="<?= $src ?>">
    <?php } ?>
    <div class="title-content">
      <div class="title">
        <?= $post->title ?>
      </div>
      <div class="content">
        <?= $post->content ?>
      </div>
    </div>
  </a>
  <div class="meta">
    <div><?= category($post->categoryIdx)->id ?></div>
    <div>79</div>
    <div><?= $post->shortDate ?></div>
  </div>
</div>

<style>
  .thumbnail-with-title-and-content,
  .thumbnail-with-title-and-content .body {
    display: flex;
    max-height: 6em;
    width: 100%;
  }

  .thumbnail-with-title-and-content .body {
    text-decoration: none;
    color: black;
  }

  .thumbnail-with-title-and-content .meta {
    display: block;
    margin-left: 15px;
    min-width: 100px;
    text-align: right;
  }

  .thumbnail-with-title-and-content .body .photo {
    margin-right: 15px;
    height: 90px;
  }

  .thumbnail-with-title-and-content .body .title-content {
    height: 100%;
    width: 100%;
    overflow: hidden;
  }


  .thumbnail-with-title-and-content .body .title-content .title {
    font-weight: bold;
    overflow: hidden;
  }

  .thumbnail-with-title-and-content .body .title-content .title,
  .thumbnail-with-title-and-content .body .title-content .content {
    height: 3em;
  }
</style>