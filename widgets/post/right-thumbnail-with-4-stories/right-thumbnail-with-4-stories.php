<?php

/**
 * @size wide
 * @options PostTaxonomy $post, boolean 'showNumber'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost(photo: true);
$showNum = $op['showNumber'] ?? false;
$posts = post()->latest(categoryIdx: $post->categoryIdx, limit: 4);
?>


<div class="right-thumbnail-with-4-stories">
  <div class="top">
    <?= $showNum ? '<span class="number">1</span>' : '' ?>
    <?php include widget('post/right-thumbnail-with-title', ['post' => $post]); ?>
  </div>
  <div class="stories">
    <?php
    $_i = 2;
    foreach ($posts as $post) { ?>
      <div>
        <a href="<?= $post->url ?>">
          <?= $showNum ? '<span class="number">' . ($_i) . '</span>' : '' ?>
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