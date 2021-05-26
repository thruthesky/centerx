<?php

/**
 * @size wide
 * @options 'firstStoriesCategory', 'reminderPost', 'secondStoriesCategory'
 * @dependency none
 */

$o = getWidgetOptions();

$firstStoriesCategory = $o['firstStoriesCategory'] ?? null;
$secondStoriesCategory = $o['secondStoriesCategory'] ?? null;
$thirdStoriesCategory = $o['thirdStoriesCategory'] ?? null;
$fourthStoriesCategory = $o['fourthStoriesCategory'] ?? null;
$reminderPost = $o['reminderPost'] ?? null;

?>


    <div class="two-column-story-group-a row">
        <div class="column-a col-12 col-lg-7">
            <?php include widget('post/left-photo-with-bulleted-text-at-right', ['post' => $firstStoriesCategory]) ?>
            <div class="mt-3"><?php include widget('post/reminder', ['post' => $reminderPost]) ?></div>
            <div class="mt-3">
                <?php include widget('post/2x2-photo-with-text-at-right', ['categoryId' => $secondStoriesCategory]) ?>
            </div>
        </div>
        <div class="column-b mt-3 col-12 col-lg-5">
            <?php include widget('post/2x2-photo-top-text-bottom', ['categoryId' => $thirdStoriesCategory, 'imageHeight' => 75]) ?>
            <div class="bottom-stories bg-light p-3 border-radius-md">
                <?php include widget('post/bulleted-text-list', ['categoryId' => $fourthStoriesCategory, 'limit' => 5]) ?>
            </div>
        </div>
    </div>

<style>
    .left-photo-with-bulleted-text-at-right .bottom li:first-child a,
    .left-photo-with-bulleted-text-at-right .bottom li:nth-child(4) a,
    .left-photo-with-bulleted-text-at-right .bottom li:last-child a {
        color: #f00000 !important;
    }
    @media all and (max-width: 768px) {
        .left-photo-with-bulleted-text-at-right .bottom li:nth-child(6),
        .left-photo-with-bulleted-text-at-right .bottom li:nth-child(7) {
            display: none;
        }
    }
</style>