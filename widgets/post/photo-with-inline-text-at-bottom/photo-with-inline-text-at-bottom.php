<?php

/**
 * @size narrow
 * @options PostTaxonomy $post
 * @dependency none
 */
$o = getWidgetOptions();
$post = $o['post'] ?? post();
$src = "/widgets/post/photo-with-inline-text-at-bottom/dog.jpg";
if ($post->exists == false) {
    // mock data
    $post->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
    $url = "javascript:alert('This is a mock data. Post data is not given!');";
} else {
    if (!empty($post->files()))
        $src = thumbnailUrl($post->files()[0]->idx, 360, 280);
    $url = $post->url;
}
?>


<a class="photo-with-inline-text-at-bottom" href="<?= $url ?>">
    <div class="photo"><img src="<?= $src ?>"></div>
    <div class="title">
        <div class="inner"><?= $post->title ?></div>
    </div>
</a>


<style>
    .photo-with-inline-text-at-bottom {
        position: relative;
        display: block;
        max-height: 200px;
        overflow: hidden;
    }

    .photo-with-inline-text-at-bottom .title {
        position: absolute;
        padding: 1em;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: .7;
        background-color: black;
        color: white;
    }

    .photo-with-inline-text-at-bottom .title .inner {
        overflow: hidden;
        height: 2.1em;
        line-height: 1em;
        font-size: 1em;
        text-align: center;
    }

    .photo-with-inline-text-at-bottom img {
        width: 100%;
    }
</style>