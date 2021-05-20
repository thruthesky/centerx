<?php

/**
 * @size narrow
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
  <!-- <img class="photo" src="<?= $src ?>"> -->
  <div class="photo" style="background: url(<?= $src ?>);"></div>
</a>

<style>
  .right-thumbnail-with-title {
    display: flex;
    width: 100%;
  }

  .right-thumbnail-with-title,
  .right-thumbnail-with-title .title {
    height: 3em;
  }

  .right-thumbnail-with-title .title {
    width: 70%;
    overflow: hidden;
    margin-right: 15px;
    font-weight: bold;
  }


  .right-thumbnail-with-title .photo {
    display: block;
    width: 30%; 
    height: 100%;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
  }
</style>