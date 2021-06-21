<?php

/**
 * @size wide
 * @options 'categoryId'
 * @description Get a photo that has photo from the category and display as primary. and Get 5 more posts to display texts.
 * @dependency none
 */

$op = getWidgetOptions();


$primary = null;
$posts = [];
if (isset($op['categoryId'])) {
  // Get primary post that has photo.
  $_posts = post()->latest(categoryId: $op['categoryId'], limit: 1, photo: true);
  if (count($_posts)) $primary = $_posts[0];

  // Get first 5 posts excluding the primary post.
  $limit = $op['limit'] ?? 6;
  $categoryId = $op['categoryId'];
  $_posts = post()->latest(categoryId: $op['categoryId'], limit: $limit);
  foreach ($_posts as $post) {
    if ($post->idx != $primary->idx) $posts[] = $post;
    if (count($posts) == 5) break;
  }
}

if (empty($primary)) {
  $primary = firstPost(photo: true);
}

$lack = 5 - count($posts);
$posts = postMockData($lack, photo: false);

?>

<div class="photo-left-texts-right d-flex w-100">
  <?php if (count($primary->files())) { ?>
    <a class="photo" href="<?= $primary->url ?>">
      <img class="w-100 rounded" src="<?= thumbnailUrl($primary->files()[0]->idx, 300, 200) ?>">
    </a>
  <?php } ?>
  <div class="posts ml-2">
    <?php foreach ($posts as $post) { ?>
      <div class="text-truncate"><a href="<?= $post->url ?>"><?= $post->title ?></a></div>
    <?php } ?>
  </div>
</div>

<style>
  .photo-left-texts-right .photo {
    width: 33%;
    line-height: 1em;
    height: 8em;
    overflow: hidden;
  }

  .photo-left-texts-right .posts {
    width: 66%;
  }

  .photo-left-texts-right .posts div a {
    text-decoration: none;
    color: black;
  }
</style>