<?php

/**
 * @size wide
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
$url = $post->url;
?>

<a class="thumbnail-with-title" href="<?= $url ?>">
  <img class="photo" src="<?= $src ?>">
  <div class="title">
    <?= $post->title ?>
  </div>
</a>

<style>
  .thumbnail-with-title {
    display: flex;
    max-height: 90px;
  }

  .thumbnail-with-title .photo {
    height: 90px;
  }

  .thumbnail-with-title .title {
    margin-left: 15px;
    height: 90px;
    font-weight: bold;
  }
</style>