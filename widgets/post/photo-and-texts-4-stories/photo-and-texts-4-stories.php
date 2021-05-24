<?php

/**
 * @size wide
 * @options 'title', 'firstCategoryId', 'secondCategoryId', 'imageHeight', 'imageWidth'
 * @dependency none
 */

$op = getWidgetOptions();

$imageHeight = $op['imageHeight'] ?? 150;
$imageWidth = $op['imageWidth'] ?? 150;
?>


<div class="photos-and-texts-2-stories">
  <?php if (isset($op['title']) && $op['title']) { ?>
    <div class="section-title">
      <?= $op['title'] ?>
    </div>
  <?php } ?>

  <div class="first-story">
    <?php include widget('post/left-photo-with-stories', ['categoryId' => $op['firstCategoryId'] ?? null]); ?>
  </div>

  <div class="second-story">
    <?php
    if (isset($op['secondCategoryId'])) {
      $posts = post()->latest(categoryId: $op['secondCategoryId'], limit: 4);
    } else {
      $posts = postMockData(4, photo: true);
    }


    for ($i = 0; $i < count($posts); $i++) {
    ?>
      <div class="story story-<?= $i ?>">
        <?php include widget('post/photo-with-text-at-bottom', [
          'post' => $posts[$i],
          'imageHeight' => $imageHeight,
          'imageWidth' => $imageWidth
        ]); ?>
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