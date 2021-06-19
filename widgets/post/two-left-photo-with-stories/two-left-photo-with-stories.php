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
    <h5 class="title m-0 text-truncate"><?= $topPost->title ?></h5>
    <div class="content text-truncate"><?= $topPost->content ?></div>
  </a>
  <div class="bottom d-flex mt-1">
    <div class="left mt-1">
      <?php foreach ($posts as $post) { ?>
        <div class="photo mb-2">
          <?php include widget('post/photo-with-inline-text-at-bottom', [
            'post' => $post,
            'imageHeight' => $imageHeight,
            'imageWidth' => $imageWidth
          ]); ?>
        </div>
      <?php } ?>
    </div>
    <div class="right ml-2">
      <?php include widget('post/bulleted-text-list', ['categoryId' => $op['categoryId'] ?? null]); ?>
    </div>
  </div>
</div>

<style>
  .two-left-photo-with-stories a {
    text-decoration: none;
    color: black;
  }

  .two-left-photo-with-stories .bottom .left {
    width: 40%;
  }

  .two-left-photo-with-stories .bottom .right {
    width: 60%;
  }
</style>