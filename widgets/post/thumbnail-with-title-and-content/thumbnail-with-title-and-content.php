<?php

/**
 * @size wide
 * @options PostTaxonomy $post
 * @dependency none
 */
$op = getWidgetOptions();

$post = $op['post'] ?? post();

$src = '/widgets/post/photo-with-text-at-bottom/panda.jpg';
if ($post->exists == false) {
  $post->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
  $post->updateMemoryData('content', 'What a lovely dog. What is your name? This is the sample content! This is very long text... Make it two lines only!');
  $post->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $post->updateMemoryData('src', $src);
} else {
  if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
  $url = $post->url;
}
?>

<a class="thumbnail-with-title-and-content" href="<?= $url ?>">
  <img class="photo" src="<?= $src ?>">
  <div class="title-content">
    <div class="title">
      <?= $post->title ?>
    </div>
    <div class="content">
      <?= $post->content ?>
    </div>
  </div>
</a>

<style>
  .thumbnail-with-title-and-content {
    display: flex;
    max-height: 90px;
  }

  .thumbnail-with-title-and-content .photo {
    height: 90px;
  }

  .thumbnail-with-title-and-content .title-content {
    margin-left: 15px;
    height: 100%;
    width: 100%;
    overflow: hidden;
  }

  .thumbnail-with-title-and-content .title-content .title {
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .thumbnail-with-title-and-content .title-content .content {
    margin-top: 18px;
    height: 50px;
  }
</style>