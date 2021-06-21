<?php

/**
 * @size narrow
 * @options 'post'. The post must have an image. 'imageHeight'
 * @dependency none
 * @description The ratio of width and height is 3:2 for the image of post only. The post must have image.
 */
$o = getWidgetOptions();
$post = $o['post'] ?? firstPost(photo: true);
$files = $post->files();
if (count($files) == 0) return;

$imageHeight = $o['imageHeight'] ?? 160;
$imageWidth = $o['imageWidth'] ?? 160;

$src = thumbnailUrl($files[0]->idx, height: $imageHeight, width: $imageWidth);
$url = $post->relativeUrl;
?>


<a class="photo-top-text-bottom" href="<?= $url ?>">
    <img src="<?= $src ?>" style="height: <?= $imageHeight ?>px;">
    <div class="title">
        <div class="inner"><?= $post->title ?></div>
    </div>
</a>

<style>
    .photo-top-text-bottom img {
        display: block;
        width: 100%;
        border-radius: 5px;
    }

    .photo-top-text-bottom .title {
        padding: .5em;
        bottom: 0;
        left: 0;
        right: 0;
        /* background-color: #ececec; */
        color: black;
    }

    .photo-top-text-bottom .title .inner {
        overflow: hidden;
        height: 2em;
        line-height: 1em;
        font-size: 1em;
        text-align: center;
    }
</style>