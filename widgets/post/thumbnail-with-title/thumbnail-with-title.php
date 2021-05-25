<?php

/**
 * @size wide
 * @options PostTaxonomy 'post', 'imageHeight', 'imageWidth'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);


$imageHeight = $op['imageHeight'] ?? 100;
$imageWidth = $op['imageWidth'] ?? 150;
$src = '';
if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, height: $imageHeight, width: $imageWidth);
$url = $post->url;
?>

<a class="thumbnail-with-title" href="<?= $url ?>" style="height: <?= $imageHeight ?>;">
  <?php if (!!$src) { ?>
    <div class="photo" style="height: <?= $imageHeight ?>;">
      <img src="<?= $src ?>">
    </div>
  <?php } ?>
  <div class="title">
    <?= $post->title ?>
  </div>
</a>

<style>
  .thumbnail-with-title {
    display: flex;
    width: 100%;
    text-decoration: none;
    color: black;
    overflow: hidden;
  }

  .thumbnail-with-title .title {
    display: block;
    margin-left: 8px;
    padding: .25em;
    width: 70%;
    /* font-weight: bold; */
    font-size: 1em;
  }

  .thumbnail-with-title .photo img {
    border-radius: 5px;
    display: block;
    width: 100%;
    height: 100%;
  }
</style>