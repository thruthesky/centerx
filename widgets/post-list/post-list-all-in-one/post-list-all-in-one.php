<?php
/**
 * @name All In One: Create, List, View
 */

$o = getWidgetOptions();
$posts = $o['posts'];


hook()->add(HOOK_POST_EDIT_RETURN_URL, function() {
    return 'list';
});
?>


<?php include widget('post-edit/post-edit-default') ?>

<section class="post-list-create-view">

    <?php foreach( $posts as $post ) { ?>
        <h1>No. <?=$post->idx?> <?=$post->title?></h1>
        <div class="content">
            <?=$post->content?>
        </div>
        <div class="files">
            <?php foreach( $post->files() as $file ) { ?>
                <div class="position-relative">
                    <img class="w-100" src="<?=$file->url?>">
                    <div class="position-absolute" style="top: 0; color: white; background-color: black;" onclick="onClickFileDelete(<?=$file->idx?>);">[ X ]</div>
                </div>
            <?php } ?>
        </div>
        <div>
            <?php include widget('comment-edit/comment-edit-default', [
                'post' => $post,
                'parent' => $post,
            ]); ?>
        </div>

        <?php

        ?>
        <div class="comments">
            <?php foreach( $post->comments() as $comment ) {  ?>
                <div class="mb-2 p-3 text-white bg-secondary" style="margin-left: <?=$comment->depth * 16?>px;">
                    No.: <?=$comment->idx?>
                    <div>
                        <?=$comment->content?>
                    </div>
                    <div class="files">
                        <?php foreach( $comment->files() as $file ) { ?>
                            <img class="w-100" src="<?=$file->url?>">
                        <?php } ?>
                    </div>
                    <div>

                        <?php include widget('comment-edit/comment-edit-default', [
                            'post' => $post,
                            'parent' => $comment,
                        ]); ?>

                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

</section>
