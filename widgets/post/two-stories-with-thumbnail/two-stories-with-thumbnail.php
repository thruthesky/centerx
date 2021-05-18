<?php

/**
 * @size wide
 * @options 'categoryId'
 * @dependency none
 */
$op = getWidgetOptions();

$categoryId = 'discussion';
if (isset($op['categoryId'])) {
  $categoryId = $op['categoryId'];
}

$posts = [];
if (category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: 2);
}

if (empty($posts)) {
  $posts = array_fill(0, 2, null);
}
?>

<div class="two-stories-with-thumbnail">

  <?php foreach ($posts as $post) { ?>
    <div class="story">
      <?php include widget('post/thumbnail-with-title-and-content', ['post' => $post]); ?>
    </div>
  <?php } ?>

</div>

<style>
  .two-stories-with-thumbnail .story {
    margin-bottom: 8px;
  }
</style>