<?php

/**
 * @size narrow
 * @options PostTaxonomy 'post', 'imageHeight', 'imageWidth'
 * @description Display 1 main post with image on top and list 5 more below from the same category as the main post.
 * @dependency none
 */


$op = getWidgetOptions();

$post = $op['post'] ?? firstPost();
$posts = post()->latest(categoryIdx: $post->categoryIdx, limit: 4);


$imageHeight = $op['imageHeight'] ?? 160;
$imageWidth = $op['imageWidth'] ?? 100;
?>

<div class="photo-with-5-texts-at-bottom d-block">

  <div class="top">
    <?php include widget('post/photo-top-text-bottom', [
      'post' => $post,
      'imageHeight' => $imageHeight,
      'imageWidth' => $imageWidth
    ]); ?>
  </div>

  <div class="posts mt-2">
    <?php foreach ($posts as $post) { ?>
      <div class="mb-2 text-truncate"><a href="<?= $post->url ?>"><?= $post->title ?></a></div>
    <?php } ?>
  </div>
</div>


<style>
  .photo-with-5-texts-at-bottom .posts div a {
    text-decoration: none;
    color: black;
  }
</style>