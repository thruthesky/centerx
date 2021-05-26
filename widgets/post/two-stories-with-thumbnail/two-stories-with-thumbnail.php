<?php

/**
 * @size wide
 * @options 'categoryId'
 * @dependency none
 * @description displays 2 stacked post, each post contains a thumbnail with title and content. It use's 'thumbnail-left-title-and-content-right' as child widget.
 */
$op = getWidgetOptions();

$categoryId = 'discussion';
$posts = [];
if (isset($op['categoryId'])) {
  $posts = post()->latest(categoryId: $op['categoryId'], limit: 2);
}

if (empty($posts)) {
  $posts = postMockData(2, photo: true);
}
?>

<div class="two-stories-with-thumbnail">

  <?php foreach ($posts as $post) { ?>
    <div class="post mb-2">
      <?php include widget('post/thumbnail-left-title-and-content-right', ['post' => $post]); ?>
    </div>
  <?php } ?>

</div>