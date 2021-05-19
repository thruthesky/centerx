<?php

/**
 * @size narrow
 * @options PostTaxonomy $post
 * @dependency none
 */
$o = getWidgetOptions();
$post = $o['post'] ?? firstPost(photo: true);
$src = thumbnailUrl($post->files()[0]->idx, 300, 200);
$url = $post->url;
?>


<a class="photo-with-one-line-text-at-bottom" href="<?= $url ?>">
    <div class="photo"><img src="<?= $src ?>"></div>
    <div class="title">
        <div class="inner"><?= $post->title ?></div>
    </div>
</a>


<style>
    .photo-with-one-line-text-at-bottom img {
        width: 100%;
    }

    .photo-with-one-line-text-at-bottom .title {
        margin-top: 5px;
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