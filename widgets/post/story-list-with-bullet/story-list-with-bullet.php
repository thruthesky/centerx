<?php

/**
 * @size narrow
 * @options string 'categoryId', 'limit',
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

if (!count($posts)) return;
?>

<div class="story-list-with-bullet">
  <ul>
    <?php foreach ($posts as $post) { ?>
      <li>
        <a href="<?= $post->url ?>"><?= $post->title ?></a>
      </li>
    <?php } ?>
  </ul>
</div>

<style>
  .story-list-with-bullet {
    list-style-position: inside;
  }

  .story-list-with-bullet ul {
    padding: 0;
  }

  .story-list-with-bullet ul li {
    margin-bottom: .3em;
    font-size: 1em;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .story-list-with-bullet ul li::before {
    margin-right: 8px;
  }

  .story-list-with-bullet ul li a {
    text-decoration: none;
    /* color: black; */
  }
</style>