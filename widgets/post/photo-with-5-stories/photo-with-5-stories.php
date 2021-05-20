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
?>

<div class="photo-with-5-stories">

  <div class="top">
    <?php include widget('post/photo-with-text-at-bottom', ['post' => $post, 'imageHeight' => $op['imageHeight'] ?? 150, 'imageWidth' => $op['imageWidth'] ?? 100 ]); ?>
  </div>

  <div class="stories">
    <?php foreach ($posts as $post) { ?>
      <div><a href="<?= $post->url ?>"><?= $post->title ?></a></div>
    <?php } ?>
  </div>
</div>


<style>
  .photo-with-5-stories {
    display: block;
  }

  .photo-with-5-stories .stories{
    margin-top: 3px;
  }

  .photo-with-5-stories .stories div {
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>