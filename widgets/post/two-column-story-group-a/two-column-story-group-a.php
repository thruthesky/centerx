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


<div class="two-column-story-group-a">
    <div class="column-a">
        <?php include widget('post/one-left-photo-with-stories', ['post' => $firstStoriesCategory]) ?>
        <?php include widget('post/reminder', ['post' => $reminderPost]) ?>
        <?php include widget('post/four-photo-with-title', ['categoryId' => $secondStoriesCategory]) ?>
    </div>
    <div class="column-b">
        <?php include widget('post/four-stories-with-thumbnail', ['categoryId' => $thirdStoriesCategory, 'imageHeight' => 75]) ?>
        <hr>
        <?php include widget('post/story-list-with-bullet', ['categoryId' => $fourthStoriesCategory, 'limit' => 5]) ?>
    </div>
</div>

<style>
    ul {
        list-style: none
    }

    li::before {
        content: "•";
    }


    .two-column-story-group-a .column-a li::before {
        color: #f00000;
    }
    .two-column-story-group-a .column-a .four-photo-with-title {
        margin-top: 8px;
    }

    .two-column-story-group-a .column-b {
        width: 100%;
        font-size: .9em;
    }

    .two-column-story-group-a .column-b hr {
        margin-bottom: .5em;
    }


    @media only screen and (min-width: 1200px) {
        .two-column-story-group-a {
            display: flex;
            max-width: 855px;
        }

        .two-column-story-group-a .column-a {
            max-width: 65%;
        }

        .two-column-story-group-a .column-b {
            max-width: 35%;
            margin-top: 8px;
            margin-left: 16px;
        }
    }

    @media only screen and (max-width: 1200px) {
        .two-column-story-group-a .column-b {
            margin-top: 16px;
        }
    }
</style>