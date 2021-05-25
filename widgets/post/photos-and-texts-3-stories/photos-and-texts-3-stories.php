<?php

/**
 * @size wide
 * @options 2 posts in $firstStories, 'title' & 'categoryId' & 'truncate' & 'limit' & 'displayNumber' inside $secondStories, 3 posts in $thirdStories
 */
$op = getWidgetOptions();
?>
<div class="photos-and-texts-3-stories">
    <div class="first-story">
        <div class="left">
            <?php
            include widget('post/photo-with-inline-text-at-bottom', ['post' => $op['firstStories'][0] ?? null]);
            ?>
        </div>
        <div class="right">
            <?php
            include widget('post/photo-with-inline-text-at-bottom', ['post' =>  $op['firstStories'][1] ?? null]);
            ?>
        </div>
    </div>

    <div class="second-story">
        <?php if (isset($op['secondStories']) && isset($op['secondStories']['title'])) { ?><div class="title"><?= $op['secondStories']['title'] ?></div><?php } ?>
        <?php include widget('post-latest/post-latest-default', $op['secondStories'] ?? []) ?>
    </div>

    <div class="third-story">
        <div class="left">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][0] ?? null]);
            ?>
        </div>
        <div class="middle">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][1] ?? null]);
            ?>
        </div>
        <div class="right">
            <?php
            include widget('post/photo-top-text-bottom', ['post' => $op['thirdStories'][2] ?? null]);
            ?>
        </div>
    </div>
</div>
<style>
    .photos-and-texts-3-stories .first-story {
        display: flex;
        margin-top: 1em;
    }

    .photos-and-texts-3-stories .first-story .left {
        margin-right: 4px;
        width: 50%;
    }

    .photos-and-texts-3-stories .first-story .right {
        margin-left: 4px;
        width: 50%;
    }

    .photos-and-texts-3-stories .third-story {
        display: flex;
        margin-top: 8px;
    }

    .photos-and-texts-3-stories .third-story .left {
        margin-right: 4px;
        width: 33%;
    }

    .photos-and-texts-3-stories .third-story .middle {
        margin-left: 2px;
        margin-right: 2px;
        width: 33%;
    }

    .photos-and-texts-3-stories .third-story .right {
        margin-left: 4px;
        width: 33%;
    }
</style>