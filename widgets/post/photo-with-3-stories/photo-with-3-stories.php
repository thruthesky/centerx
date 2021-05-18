<?php


/**
 * @size wide
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? post();
$categoryIdx;

$otherPosts = [];

if ($post->exists == false) {
  $post->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
  $post->updateMemoryData('content', 'What a lovely dog. What is your name? This is the sample content! This is very long text... Make it two lines only!');
  $post->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $post->updateMemoryData('src', $src);
  $otherPosts = array_fill(0, 3, null);
} else {
  $posts = post()->latest(categoryIdx: $post->categoryIdx, limit: 3);
}

?>

<div class="photo-with-3-story-list">
  <div class="top">
    <?php include widget('post/photo-with-inline-text-at-bottom', ['post' => $post]); ?>
  </div>
  <div class="list">
    <?php foreach ($posts as $post) { ?>
      <div class="story">
        <?php include widget('post/thumbnail-with-title', ['post' => $post]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>

    .photo-with-3-story-list .list .story {
      margin-top: 8px;
    }

</style>