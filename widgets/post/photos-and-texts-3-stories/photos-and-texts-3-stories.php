<?php

/**
 * @size wide
 * @options 2 posts in $firstStories, 'title' & 'categoryId' & 'truncate' & 'limit' & 'displayNumber' inside $secondStories, 3 posts in $thirdStories
 */
$op = getWidgetOptions();
?>
<div class="photos-and-texts-3-stories">
    <div class="first-story d-flex mt-1">
        <div class="left w-50 mr-2">
            <?php
            include widget('post/photo-with-inline-text-at-bottom', ['post' => $op['firstStories'][0] ?? null]);
            ?>
        </div>
        <div class="right w-50 ml-2">
            <?php
            include widget('post/photo-with-inline-text-at-bottom', ['post' =>  $op['firstStories'][1] ?? null]);
            ?>
        </div>
    </div>

    <div class="second-story">
        <?php if (isset($op['secondStories']) && isset($op['secondStories']['title'])) { ?><div class="title"><?= $op['secondStories']['title'] ?></div><?php } ?>
        <?php include widget('post-latest/post-latest-default', $op['secondStories'] ?? []) ?>
    </div>

    <div class="third-story d-flex">
        <div class="left mr-2">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][0] ?? null]);
            ?>
        </div>
        <div class="middle mx-1">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][1] ?? null]);
            ?>
        </div>
        <div class="right ml-2">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][2] ?? null]);
            ?>
        </div>
    </div>
</div>
<style>
    .photos-and-texts-3-stories .third-story .left,
    .photos-and-texts-3-stories .third-story .middle,
    .photos-and-texts-3-stories .third-story .right {
        width: 33%;
    }
</style>