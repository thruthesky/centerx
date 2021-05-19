<?php

/**
 * @size wide
 * @options PostTaxonomy $post, boolean 'displayNumber'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);
$displayNumber = $op['displayNumber'] ?? false;
$posts = post()->latest(categoryId: $post->categoryId, limit: 4);
?>


<div class="right-thumbnail-with-4-stories">
  <div class="top">
    <?= $displayNumber ? '<span class="number">1</span>' : '' ?>
    <?php include widget('post/right-thumbnail-with-title', ['post' => $post]); ?>
  </div>
  <div class="stories">
    <?php
    $_i = 1;
    foreach ($posts as $post) {
      $_i++;
    ?>
      <div>
        <a href="<?= $post->url ?>">
          <?= $displayNumber ? '<span class="number">' . ($_i) . '</span>' : '' ?>
          <?= $post->title ?>
        </a>
      </div>
    <?php } ?>
  </div>
</div>


<style>
  .right-thumbnail-with-4-stories .top {
    display: flex;
  }

  .right-thumbnail-with-4-stories .stories div {
    margin-top: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .right-thumbnail-with-4-stories .top {
    display: flex;
  }

  .right-thumbnail-with-4-stories .top .number,
  .right-thumbnail-with-4-stories .stories .number {
    margin-right: 8px;
  }
</style>