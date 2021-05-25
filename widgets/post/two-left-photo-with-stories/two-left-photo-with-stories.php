<?php

/**
 * @size wide
 * @options PostTaxonomy 'post', 'categoryId' & 'imageHeight' & 'imageWidth'
 * @dependencies none
 * @description It display 1 post at top, 2 photo of post on lower left and list of post on lower right.
 */
$op = getWidgetOptions();
$posts = [];

$categoryId = 'discussion';
if (isset($op['categoryId']) && category($categoryId)->exists) {
  $posts = post()->latest(categoryId: $categoryId, limit: 2, photo: true);
}
$lack = 2 - count($posts);
$posts = array_merge($posts, postMockData($lack, photo: true));

$topPost = $op['firstPost'] ?? firstPost();

$imageHeight = $op['imageHeight'] ?? 152;
$imageWidth = $op['imageWidth'] ?? 200;
?>

<div class="two-left-photo-with-stories">
  <a class="top" href="<?= $topPost->url ?>">
    <div class="title"><?= $topPost->title ?></div>
    <div class="content"><?= $topPost->content ?></div>
  </a>
  <div class="bottom">
    <div class="left">
      <?php foreach ($posts as $post) { ?>
        <?php include widget('post/photo-with-inline-text-at-bottom', [
          'post' => $post,
          'imageHeight' => $imageHeight,
          'imageWidth' => $imageWidth
        ]); ?>
      <?php } ?>
    </div>
    <div class="right">
      <?php include widget('post/story-list-with-bullet', ['categoryId' => $op['categoryId'] ?? null]); ?>
    </div>
  </div>
</div>

<style>
  .two-left-photo-with-stories .top {
    text-decoration: none;
    color: black;
  }

  .two-left-photo-with-stories .top .title {
    font-weight: bold;
    font-size: 1em;
  }


  .two-left-photo-with-stories .top .title,
  .two-left-photo-with-stories .top .content {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .two-left-photo-with-stories .top .content {
    font-size: 1em;
  }

  .two-left-photo-with-stories .bottom {
    display: flex;
    margin-top: 2px;
  }

  .two-left-photo-with-stories .bottom .left {
    width: 40%;
  }

  .two-left-photo-with-stories .bottom .left .photo {
    margin-top: 2px;
  }

  .two-left-photo-with-stories .bottom .right {
    margin-left: 8px;
    width: 60%;
  }
</style>