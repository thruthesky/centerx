<?php

/**
 * @size wide
 * @options 'categoryId', 'imageHeight'
 * @dependency none
 */

$o = getWidgetOptions();

$categoryId = $o['categoryId'] ?? 'discussion';
if (category($categoryId)->exists) {
  $primaryPost = post()->latest(categoryId: $categoryId, photo: true);
}

if (! count($primaryPost)) {
  $primaryPost = firstPost(photo: true);
} else {
  $primaryPost = $primaryPost[0];
}

// d($primaryPost);
// d($primaryPost->files());
$imageHeight = $o['imageHeight'] ?? 190;

?>


<div class="one-left-photo-with-stories">
  <div class="top"><a href="<?= $primaryPost->url ?>"><?= $primaryPost->title ?></a></div>
  <div class="bottom">
    <a href="<?= $primaryPost->url ?>">
      <img class="photo" src="<?= thumbnailUrl($primaryPost->files()[0]->idx, height: $imageHeight, width: 190) ?>" style="height: <?= $imageHeight ?>px;">
    </a>
    <div class="stories">
      <?php include widget('post/story-list-with-bullet', ['categoryId' => $categoryId, 'limit' => 7]) ?>
    </div>
  </div>
</div>

<style>
  .one-left-photo-with-stories {
    width: 100%;
  }

  .one-left-photo-with-stories .top {
    width: 100%;
    font-size: 1.5em;
    font-weight: bold;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .one-left-photo-with-stories .bottom {
    display: flex;
  }

  .one-left-photo-with-stories a {
    text-decoration: none;
    color: #1f1f1f;
  }

  .one-left-photo-with-stories .bottom a .photo {
    border-radius: 5px;
    margin-top: 8px;
  }

  .one-left-photo-with-stories .bottom .stories {
    max-width: 65%;
    padding-left: 16px;
    overflow: hidden;
    font-weight: bold;
  }

  .one-left-photo-with-stories .bottom li:first-child a,
  .one-left-photo-with-stories .bottom li:nth-child(4) a,
  .one-left-photo-with-stories .bottom li:last-child a {
    color: #f00000 !important;
  }
</style>