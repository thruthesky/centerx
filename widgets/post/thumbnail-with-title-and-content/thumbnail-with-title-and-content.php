<?php

/**
 * @size wide
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost();
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
$url = $post->url;
?>

<a class="thumbnail-with-title-and-content" href="<?= $url ?>">
  <img class="photo" src="<?= $src ?>">
  <div class="title-content">
    <div class="title">
      <?= $post->title ?>
    </div>
    <div class="content">
      <?= $post->content ?>
    </div>
  </div>
</a>

<style>
  .thumbnail-with-title-and-content {
    display: flex;
    max-height: 90px;
  }

  .thumbnail-with-title-and-content .photo {
    height: 90px;
  }

  .thumbnail-with-title-and-content .title-content {
    margin-left: 15px;
    height: 100%;
    width: 100%;
    overflow: hidden;
  }

  
  .thumbnail-with-title-and-content .title-content .title {
    font-weight: bold;
    overflow: hidden;
  }

  .thumbnail-with-title-and-content .title-content .title, 
  .thumbnail-with-title-and-content .title-content .content {
    height: 3em;
  }
</style>