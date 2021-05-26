<?php

/**
 * @size narrow
 * @options PostTaxonomy $post, boolean 'displayNumber', 'imageHeight', 'imageWidth'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);
$displayNumber = $op['displayNumber'] ?? false;
$posts = post()->latest(categoryId: $post->categoryId, limit: 4);

$imageHeight = $op['imageHeight'] ?? 50;
$imageWidth = $op['imageWidth'] ?? 50;
?>


<div class="text-left-thumbnail-right-top-4-texts-bottom">
  <div class="top d-flex">
    <?= $displayNumber ? '<span class="number mr-2">1</span>' : '' ?>
    <?php include widget('post/title-left-thumbnail-right', [
      'post' => $post,
      'imageHeight' => $imageHeight,
      'imageWidth' => $imageWidth
    ]); ?>
  </div>
  <div class="posts">
    <?php
    $_i = 1;
    foreach ($posts as $post) {
      $_i++;
    ?>
      <div class="mt-2 text-truncate">
        <a href="<?= $post->url ?>">
          <?= $displayNumber ? '<span class="number mr-2">' . ($_i) . '</span>' : '' ?><?= $post->title ?>
        </a>
      </div>
    <?php } ?>
  </div>
</div>


<style>
  .text-left-thumbnail-right-top-4-texts-bottom a {
    text-decoration: none;
    color: black;
  }
</style>