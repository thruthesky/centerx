<?php

/**
 * @size wide
 * @options 'firstStoriesCategory' 'reminderPost', 'thirdStoriesCategory'
 * @dependency none
 */

$o = getWidgetOptions();

$firstStoriesCategory = $o['firstStoriesCategory'] ?? null;
$thirdStoriesCategory = $o['thirdStoriesCategory'] ?? null;
$reminderPost = $o['reminderPost'] ?? null;

?>


<div class="d-xl-flex">
    <div style="overflow: hidden">
        <!-- right - top -->
        <?php include widget('post/one-left-photo-with-stories', ['post' => $firstStoriesCategory]) ?>
        <!-- right - middle -->
        <?php include widget('post/reminder', ['post' => $reminderPost]) ?>
        <!-- right - bottom -->
        <div class="mt-3">
            <?php include widget('post/four-photo-with-title', ['categoryId' => $thirdStoriesCategory]) ?>
        </div>
    </div>
    <div>

    </div>
</div>

<style>
    ul {
        list-style: none
    }

    li::before {
        content: "•";
        color: red
    }
</style>