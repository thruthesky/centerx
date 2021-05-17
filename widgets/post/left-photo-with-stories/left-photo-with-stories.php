<?php

/**
 * @size wide
 * @options title, 1 post in $firstStories, 'categoryId' inside $secondStories.
 */

$op = getWidgetOptions();

$limit = $op['limit'] ?? 5;
$categoryId = $op['categoryId'] ?? 'qna';

$posts = post()->latest(categoryId: $op['categoryId'] ?? $categoryId, limit: $limit);

// default image if first story post doesn't have image
$src = "/widgets/post/photo-with-text-at-bottom/panda.jpg";
if ($posts[0] && !empty($posts[0]->files())) {
  $src = thumbnailUrl($posts[0]->files()[0]->idx, 300, 200);
}
?>

<div class="left-photo-with-stories">
  <div class="section-image"><img src="<?= $src ?>"></div>
  <div class="stories">
    <?php foreach ($posts as $post) { ?>
      <div><a href="<?= $post->url ?>"><?= $post->title ?></a></div>
    <?php } ?>
  </div>
</div>

<style>
  .left-photo-with-stories {
    display: flex;
    width: 100%;
  }

  .left-photo-with-stories .section-image {
    width: 33%;
  }

  .left-photo-with-stories .section-image img {
    width: 100%;
  }

  .left-photo-with-stories .stories {
    width: 66%;
    margin-left: 5px;
  }

  .left-photo-with-stories .stories div {
    margin-bottom: 2px;
    padding-right: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>