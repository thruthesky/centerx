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

if (!count($primaryPost)) {
  $primaryPost = firstPost(photo: true);
} else {
  $primaryPost = $primaryPost[0];
}

// d($primaryPost);
// d($primaryPost->files());
$imageHeight = $o['imageHeight'] ?? 190;

if (!$primaryPost) return;

?>


<div class="one-left-photo-with-stories">
  <a class="h4" href="<?= $primaryPost->url ?>"><?= $primaryPost->title ?></a>
  <div class="bottom row mt-2">
    <?php if (count($primaryPost->files())) { ?>
        <div class="col-5">
            <a href="<?= $primaryPost->url ?>">
                <img class="photo w-120px w-lg-100 border-radius-sm" src="<?= thumbnailUrl($primaryPost->files()[0]->idx, height: $imageHeight, width: 190) ?>">
            </a>
        </div>
    <?php } ?>
    <div class="stories col-7 pl-0">
      <?php include widget('post/story-list-with-bullet', ['categoryId' => $categoryId, 'limit' => 7]) ?>
    </div>
  </div>
</div>
