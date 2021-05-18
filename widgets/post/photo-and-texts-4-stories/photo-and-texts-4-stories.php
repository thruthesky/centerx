<?php

/**
 * @size wide
 * @options 'title', 'firstCategoryId', 'secondCategoryId'
 * @dependency none
 */

$op = getWidgetOptions();
?>


<div class="photos-and-texts-2-stories">
  <?php if (isset($op['title']) && $op['title']) { ?>
    <div class="section-title">
      <?= $op['title'] ?>
    </div>
  <?php } ?>

  <div class="first-story">
    <?php include widget('post/left-photo-with-stories', ['categoryId' => $op['firstCategroyId'] ?? null]); ?>
  </div>

  <div class="second-story">
    <?php
    if ( isset($op['secondCategroyId']) ) {
        $posts = post()->latest(categoryId: $op['secondCategroyId'], limit: 4);
    } else {
        $posts = postMockData(4, photo: true);
    }


    for ($i = 0; $i < 4; $i++) {
        ?>
      <div class="story story-<?=$i?>">
        <?php include widget('post/photo-with-text-at-bottom', ['post' => $posts[$i] ]); ?>
      </div>
    <?php } ?>
  </div>
</div>

<style>
  .photos-and-texts-2-stories .section-title {
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
  }

  .photos-and-texts-2-stories .second-story {
    margin-top: 8px;
    display: flex;
  }

  .photos-and-texts-2-stories .second-story .story {
    width: 25%;
  }

  .photos-and-texts-2-stories .second-story .story-1 {
    margin-right: 4px;
    margin-left: 8px;
  }

  .photos-and-texts-2-stories .second-story .story-2 {
    margin-right: 8px;
    margin-left: 4px;
  }
</style>