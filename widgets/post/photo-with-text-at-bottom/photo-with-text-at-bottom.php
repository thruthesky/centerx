<?php

/**
 * @size narrow
 * @options 'post'. The post must have an image.
 * @dependency none
 * @description The ratio of width and height is 3:2 for the image of post only. The post must have image.
 */
$o = getWidgetOptions();
$post = $o['post'] ?? firstPost();
$files = $post->files();
if ( count($files) == 0 ) return;
$src = thumbnailUrl($files[0]->idx, 300, 200);
$url = $post->url;
?>


<a class="photo-with-text-at-bottom" href="<?= $url ?>">
    <div class="photo"><img src="<?= $src ?>"></div>
    <div class="title">
        <div class="inner"><?= $post->title ?></div>
    </div>
</a>


<style>
    .photo-with-text-at-bottom {
        display: block;
    }

    .photo-with-text-at-bottom img {
        width: 100%;
    }

    .photo-with-text-at-bottom .title {
        padding: 1em;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #ececec;
        color: black;
    }

    .photo-with-text-at-bottom .title .inner {
        overflow: hidden;
        height: 2.1em;
        line-height: 1em;
        font-size: 1em;
        text-align: center;
    }
</style>