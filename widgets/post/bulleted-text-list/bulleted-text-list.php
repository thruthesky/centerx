<?php

/**
 * @size narrow
 * @options string 'categoryId', 'limit',
 * @dependencies none
 */

$opt = getWidgetOptions();

$limit = $opt['limit'] ?? 11;

if ($limit > 11) $limit = 11;

$categoryId = 'discussion';
if (isset($opt['categoryId'])) {
  $categoryId = $opt['categoryId'];
}


$posts = [];
if (category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: $limit);
}

$lack = $limit - count($posts);
$posts = array_merge($posts, postMockData($lack));

if (!count($posts)) return;
?>

<div class="story-list-with-bullet">
  <ul class="list-style-none ellipsis">
    <?php foreach ($posts as $post) { ?>
      <li class="text-truncate">
        <a href="<?= $post->url ?>"><?= $post->title ?></a>
      </li>
    <?php } ?>
  </ul>
</div>
