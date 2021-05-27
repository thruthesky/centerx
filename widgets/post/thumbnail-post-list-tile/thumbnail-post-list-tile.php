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

<a class="thumbnail-post-list-tile" href="<?= $url ?>">
  <div class="body" style="height: <?= $imageHeight ?>px">
    <?php if ($src) { ?>
      <img class="mr-3 rounded" class="photo" src="<?= $src ?>">
    <?php } ?>
    <div class="title-content">
      <div class="title font-weight-bold">
        <small>No. <?= $post->idx ?></small>
        <?= $post->title ?>
      </div>
      <div class="content">
        <?= $post->content ?>
      </div>
    </div>
  </div>
  <div class="meta">
    <strong><?= $post->user()->nicknameOrName ?></strong>
    <div>
      <span class="badge badge-info inline-block"><?= category($post->categoryIdx)->id ?></span>
    </div>
    <?= ln('no_of_views') ?>: <?= $post->noOfViews ?>
    <div><?= $post->shortDate ?></div>
  </div>
</a>

<style>
  .thumbnail-post-list-tile,
  .thumbnail-post-list-tile .body {
    overflow: hidden;
    display: flex;
    max-height: 6em;
    width: 100%;
    text-decoration: none;
    color: black;
  }

  .thumbnail-post-list-tile .meta {
    display: block;
    margin-left: 15px;
    min-width: 100px;
    text-align: right;
  }

  .thumbnail-post-list-tile .body .title-content {
    height: 100%;
    width: 100%;
    overflow: hidden;
  }


  .thumbnail-post-list-tile .body .title-content .title {
    overflow: hidden;
  }

  .thumbnail-post-list-tile .body .title-content .title,
  .thumbnail-post-list-tile .body .title-content .content {
    height: 3em;
  }
</style>