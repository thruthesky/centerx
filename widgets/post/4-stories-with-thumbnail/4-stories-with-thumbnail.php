<?php

/**
 * @size narrow
 * @options 'categoryId'
 * @dependency none
 */

$op = getWidgetOptions();
?>


<div class="post-4-stories-with-thumbnail">
  <div class="stories">
    <?php
    $posts = post()->latest(categoryId: $op['categoryId'] ?? 'discussion', limit: 4);
    for ($i = 0; $i < 4; $i++) { ?>
      <div class="story">
        <?php include widget('post/photo-with-text-at-bottom', ['post' => $posts[$i] ?? null]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .post-4-stories-with-thumbnail .stories {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
  }

  .post-4-stories-with-thumbnail .stories .story {
    width: 50%;
    padding: 2px;
  }
</style>