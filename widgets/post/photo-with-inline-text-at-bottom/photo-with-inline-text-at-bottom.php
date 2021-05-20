<?php

/**
 * @size narrow
 * @options PostTaxonomy $post, $height
 * @dependency none
 */
$o = getWidgetOptions();
$post = $o['post'] ?? firstPost(photo: true);
$height = $o['height'] ?? 200;
$files = $post->files();
if (count($files) == 0) return;
$src = thumbnailUrl($files[0]->idx, 360, $height);
$url = $post->url;
?>


<a class="photo-with-inline-text-at-bottom" 
    href="<?= $url ?>"
    style="height: <?=$height?>px" 
>
    <div class="photo" style="background: url(<?= $src ?>);"></div>
    <div class="title">
        <div class="inner"><?= $post->title ?></div>
    </div>
</a>


<style>
    .photo-with-inline-text-at-bottom {
        position: relative;
        display: block;
        overflow: hidden;
        /* max-height: 200px; */
    }

    .photo-with-inline-text-at-bottom .title {
        position: absolute;
        padding: .5em;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: .7;
        background-color: black;
        color: white;
    }

    .photo-with-inline-text-at-bottom .title .inner {
        overflow: hidden;
        height: 2em;
        line-height: 1em;
        font-size: 1em;
        text-align: center;
    }

    .photo-with-inline-text-at-bottom img {
        width: 100%;
        /* height: 100%; */
    }

    .photo-with-inline-text-at-bottom .photo {
        width: 100%;
        height: 100%;
        background-repeat: no-repeat !important;
        background-size: cover !important;
        background-position: center !important;
    }
</style>