<?php

/**
 * @size narrow
 * @options 'categoryId'
 * @dependencies none
 */
$op = getWidgetOptions();

$posts = [];

$categoryId = 'discussion';
if (isset($op['categoryId']) && category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: 6);
}

$lack = 6 - count($posts);
$posts = array_merge($posts, postMockData($lack));

?>

<div class="top-6-post-list">
  <?php
  $_num = 0;
  foreach ($posts as $post) {
    $_num++; ?>
    <a class="d-block text-truncate" href="<?= $post->url ?>">
      <span class="number <?= $_num < 4 ? 'blue' : ''?>"><?= $_num ?></span>
      <span><?= $post->title ?></span>
    </a>
  <?php } ?>
</div>

<style>
  .top-6-post-list {
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .top-6-post-list a {
    text-decoration: none;
    color: black;
  }

  .top-6-post-list a .blue {
    color: darkcyan;
  }

  .top-6-post-list .number {
    font-weight: bold;
    margin-right: 8px;
  }
</style>