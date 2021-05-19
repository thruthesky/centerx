<?php

/**
 * @size wide
 * @options string 'categoryId', 'limit'
 * @dependencies none
 */

$op = getWidgetOptions();

$limit = $op['limit'] ?? 11;

if ($limit > 11) $limit = 11;

$categoryId = 'discussion';
if (isset($op['categoryId'])) {
  $categoryId = $op['categoryId'];
}

$posts = [];
if (category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: $limit);
}

$lack = $limit - count($posts);
$posts = array_merge($posts, postMockData($lack));

?>

<div class="story-list-with-bullet">
  <ul>
    <?php foreach ($posts as $post) { ?>
      <li>
        <div>
          <a href="<?= $post->url ?>"><?= $post->title ?></a>
        </div>
      </li>
    <?php } ?>
  </ul>
</div>

<style>
  .story-list-with-bullet ul {
    list-style-type: circle;
    padding-top: .5em;
  }

  .story-list-with-bullet ul li div {
    margin-bottom: .5em;
    font-size: 1.2em;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
</style>