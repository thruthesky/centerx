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
  $post->updateMemoryData('title', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
  $post->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $post->updateMemoryData('src', $src);
} else {
  if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
  $url = $post->url;
}
?>

<a class="thumbnail-with-title" href="<?= $url ?>">
  <img class="photo" src="<?= $src ?>">
  <div class="title">
    <?= $post->title ?>
  </div>
</a>

<style>
  .thumbnail-with-title {
    display: flex;
    max-height: 90px;
  }

  .thumbnail-with-title .photo {
    height: 90px;
  }

  .thumbnail-with-title .title {
    margin-left: 15px;
    height: 90px;
    font-weight: bold;
  }

</style>