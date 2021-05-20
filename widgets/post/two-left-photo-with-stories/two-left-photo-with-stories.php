<?php

/**
 * @size wide
 * @options PostTaxonomy 'post', 2 post for 'secondStories'
 * @dependencies none
 * @description It display 1 post at top, 2 photo of post on lower left and list of post on lower right.
 */
$op = getWidgetOptions();

$post = $op['post'] ?? firstPost();
?>

<div class="two-left-photo-with-stories">
  <a class="top" href="<?= $post->url ?>">
    <div class="title"><?= $post->title ?></div>
    <div class="content"><?= $post->content ?></div>
  </a>
  <div class="bottom">
    <div class="left">
      <div class="photo">
        <?php include widget('post/photo-with-inline-text-at-bottom', $op['secondStories'][0] ?? []); ?>
      </div>
      <div class="photo">
        <?php include widget('post/photo-with-inline-text-at-bottom', $op['secondStories'][1] ?? []); ?>
      </div>
    </div>
    <div class="right">
      <?php include widget('post/story-list-with-bullet', [ 'categoryId' => $op['categoryId'] ?? null ]); ?>
    </div>
  </div>
</div>

<style>
  .two-left-photo-with-stories .top .title {
    font-weight: bold;
    font-size: 1.2em;
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
  }

  .two-left-photo-with-stories .bottom .left {
    width: 40%;
  }

  .two-left-photo-with-stories .bottom .left .photo {
    margin-top: 8px;
  }

  .two-left-photo-with-stories .bottom .right {
    margin-left: 4px;
    width: 60%;
  }
</style>