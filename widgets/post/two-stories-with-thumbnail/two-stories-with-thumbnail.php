<?php

/**
 * @size wide
 * @options 'categoryId'
 * @dependency none
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