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
  $post->updateMemoryData('title', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. asdasd asd asd asd asd asd asd asd asd asd asd asd asd sad sad sad asd sad asd ');
  $post->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $post->updateMemoryData('src', $src);
} else {
  if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
  $url = $post->url;
}
?>

<a class="right-thumbnail-with-title" href="<?= $url ?>">
  <div class="title">
    <?= $post->title ?>
  </div>
  <img class="photo" src="<?= $src ?>">
</a>

<style>
  .right-thumbnail-with-title {
    display: flex;
  }

  .right-thumbnail-with-title,
  .right-thumbnail-with-title .photo,
  .right-thumbnail-with-title .title {
    height: 4.8em;
  }

  .right-thumbnail-with-title .title {
    overflow: hidden;
    margin-right: 15px;
    font-weight: bold;
  }
</style>