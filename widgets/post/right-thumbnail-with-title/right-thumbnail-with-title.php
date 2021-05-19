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

<a class="right-thumbnail-with-title" href="<?= $url ?>">
  <div class="title">
    <?= $post->title ?>
  </div>
  <img class="photo" src="<?= $src ?>">
</a>

<style>
  .right-thumbnail-with-title {
    display: flex;
  }

  .right-thumbnail-with-title,
  .right-thumbnail-with-title .photo,
  .right-thumbnail-with-title .title {
    height: 4.8em;
  }

  .right-thumbnail-with-title .title {
    overflow: hidden;
    margin-right: 15px;
    font-weight: bold;
  }
</style>