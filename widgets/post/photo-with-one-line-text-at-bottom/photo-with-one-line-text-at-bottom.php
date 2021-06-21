<?php

/**
 * @size narrow
 * @options PostTaxonomy 'post', 'imageHeight', 'imageWidth'
 * @dependency none
 */
$o = getWidgetOptions();
$post = $o['post'] ?? firstPost(photo: true);

$imageHeight = $o['imageHeight'] ?? 200;
$imageWidth = $o['imageWidth'] ?? 200;

if (!count($post->files())) return;

$src = thumbnailUrl($post->files()[0]->idx, height: $imageHeight, width: $imageWidth);
$url = $post->url;
?>


<a class="photo-with-one-line-text-at-bottom" href="<?= $url ?>">
    <div class="photo" style="height: <?= $imageHeight ?>px"><img src="<?= $src ?>"></div>
    <div class="title">
        <div class="inner"><?= $post->title ?></div>
    </div>
</a>


<style>
    .photo-with-one-line-text-at-bottom {
        height: 100%;
    }

    .photo-with-one-line-text-at-bottom img {
        width: 100%;
        height: 100%;
    }

    .photo-with-one-line-text-at-bottom .title {
        height: 2em;
        padding: .25em;
        background-color: #ececec;
        color: black;
    }

    .photo-with-one-line-text-at-bottom .title .inner {
        overflow: hidden;
        font-weight: bold;
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 1em;
    }
</style>