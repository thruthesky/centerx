<?php

/**
 * @size narrow
 * @options PostTaxonomy $post
 * @dependency none
 */
$o = getWidgetOptions();
$post = $o['post'] ?? post();
$src = "/widgets/post/photo-with-one-line-text-at-bottom/dog.jpg";
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