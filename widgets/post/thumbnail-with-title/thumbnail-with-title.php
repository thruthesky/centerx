<?php

/**
 * @size narrow
 * @options PostTaxonomy $post, $imageHeight
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
$url = $post->url;
?>

<a class="thumbnail-with-title" href="<?= $url ?>">
  <div class="photo" style="background: url(<?= $src ?>);"></div>
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
    margin-left: 15px;
    width: 70%;
    font-weight: bold;
    font-size: 1em;
  }

  .thumbnail-with-title .photo {
    display: block;
    width: 30%;
    height: 100%;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
  }
</style>