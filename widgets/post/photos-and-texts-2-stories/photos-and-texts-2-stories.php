<?php

/**
 * @size wide
 * @options title, 1 'categoryId' & '$limit' in $firstStories, 'categoryId' inside $secondStories.
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
    <?php include widget('post/left-photo-with-stories', $op['firstStories']); ?>
  </div>

  <div class="second-story">
    <?php $posts = post()->latest(categoryId: $op['categoryId'] ?? 'qna', limit: 4);
    for ($i = 0; $i < 4; $i++) { ?>
      <div class="story story-<?=$i?>">
        <?php include widget('post/photo-with-text-at-bottom', ['post' => $posts[$i] ?? null]); ?>
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
    display: flex;
    margin-top: 4px;
  }

  .photos-and-texts-2-stories .second-story .story {
    width: 25%;
  }

  .photos-and-texts-2-stories .second-story .story-1 {
    margin-right: 2px;
    margin-left: 4px;
  }

  .photos-and-texts-2-stories .second-story .story-2 {
    margin-right: 4px;
    margin-left: 2px;
  }
</style>