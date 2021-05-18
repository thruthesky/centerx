<?php

/**
 * @size wide
 * @options PostTaxonomy $post, boolean 'showNumber'
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? post();
$categoryIdx;
$otherPosts = [];
$showNum = $op['showNumber'] ?? true;

if ($post->exists == false) {
  $post->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
  $post->updateMemoryData('content', 'What a lovely dog. What is your name? This is the sample content! This is very long text... Make it two lines only!');
  $post->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $post->updateMemoryData('src', $src);
  $otherPosts = array_fill(0, 4, null);
} else {
  $posts = post()->latest(categoryIdx: $post->categoryIdx, limit: 4);
}

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
          <?= '<span class="number">' . ($_i) . '</span>' ?>
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