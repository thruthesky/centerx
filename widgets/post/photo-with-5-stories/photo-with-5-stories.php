<?php

/**
 * @size narrow
 * @options PostTaxonomy $post
 * @description Display 1 main post with image on top and list 5 more below from the same category as the main post.
 * @dependency none
 */


$op = getWidgetOptions();

$posts = [];
if (isset($op['post'])) {
  $primaryPost = $op['post'];
  $categoryIdx = $primaryPost->categoryIdx;
  $posts = post()->latest(categoryIdx: $categoryIdx, limit: 5);
} else {
  $primaryPost = post();
  $primaryPost->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
  $primaryPost->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $posts = array_fill(0, 5, $primaryPost);
}

?>

<div class="photo-with-5-stories">

  <div class="top">
    <?php include widget('post/photo-with-text-at-bottom', ['post' => $primaryPost]); ?>
  </div>

  <div class="stories">
    <?php foreach ($posts as $post) { ?>
      <div><a href="<?= $post->url ?>"><?= $post->title ?></a></div>
    <?php } ?>
  </div>
</div>


<style>
  .photo-with-5-stories .stories div {
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>