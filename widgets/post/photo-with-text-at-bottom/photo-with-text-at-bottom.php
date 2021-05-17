<?php

/**
 * @size narrow
 * @options PostTaxonomy $post
 * @dependency none
 * @description The ratio of width and height is 3:2 for the image of post only.
 */
$o = getWidgetOptions();
$post = $o['post'] ?? post();
$src = "/widgets/post/photo-with-text-at-bottom/panda.jpg";
if ($post->exists == false) {
    // mock data
    $post->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
    $url = "javascript:alert('This is a mock data. Post data is not given!');";
} else {
    if (!empty($post->files()))
        $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
    $url = $post->url;
}
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