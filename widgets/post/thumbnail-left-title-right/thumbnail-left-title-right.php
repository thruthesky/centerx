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

<a class="thumbnail-left-title-right" href="<?= $url ?>" style="height: <?= $imageHeight ?>;">
  <?php if (!!$src) { ?>
      <img class="photo" src="<?= $src ?>" style="height: <?= $imageHeight ?>;">
    
  <?php } ?>
  <div class="title">
    <?= $post->title ?>
  </div>
</a>

<style>
  .thumbnail-left-title-right {
    display: flex;
    width: 100%;
    text-decoration: none;
    color: black;
    overflow: hidden;
  }

  .thumbnail-left-title-right .title {
    display: block;
    margin-left: 8px;
    padding: .25em;
    width: 65%;
    /* font-weight: bold; */
    font-size: 1em;
  }

  .thumbnail-left-title-right .photo {
    border-radius: 5px;
    display: block;
    width: 35%;
    height: 100%;
  }
</style>