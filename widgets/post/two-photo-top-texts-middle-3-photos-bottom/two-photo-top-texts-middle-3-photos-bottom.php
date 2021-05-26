<?php

/**
 * @size wide
 * @options 2 posts in $firstStories, 'title' & 'categoryId' & 'truncate' & 'limit' & 'displayNumber' inside $secondStories, 3 posts in $thirdStories
 */
$op = getWidgetOptions();
?>
<div class="two-photo-top-texts-middle-3-photos-bottom">
    <div class="first-story d-flex mt-1">
        <div class="left w-50 mr-1">
            <?php
            include widget('post/photo-with-inline-text-at-bottom', ['post' => $op['firstStories'][0] ?? null]);
            ?>
        </div>
        <div class="right w-50 ml-1">
            <?php
            include widget('post/photo-with-inline-text-at-bottom', ['post' =>  $op['firstStories'][1] ?? null]);
            ?>
        </div>
    </div>

    <div class="second-story mt-1">
        <?php if (isset($op['secondStories']) && isset($op['secondStories']['title'])) { ?><div class="title"><?= $op['secondStories']['title'] ?></div><?php } ?>
        <?php include widget('post-latest/post-latest-default', $op['secondStories'] ?? []) ?>
    </div>

    <div class="third-story d-flex mt-1">
        <div class="left mr-1">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][0] ?? null]);
            ?>
        </div>
        <div class="middle mx-1">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][1] ?? null]);
            ?>
        </div>
        <div class="right ml-1">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][2] ?? null]);
            ?>
        </div>
    </div>
</div>
<style>
    .two-photo-top-texts-middle-3-photos-bottom .third-story .left,
    .two-photo-top-texts-middle-3-photos-bottom .third-story .middle,
    .two-photo-top-texts-middle-3-photos-bottom .third-story .right {
        width: 33%;
    }
</style>