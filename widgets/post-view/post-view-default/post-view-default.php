<?php

/**
 * @name Default Post View
 */


$post = post()->current();


?>

<section class="p-3" style="border-radius: 10px; background-color: #f4f4f4;">
    <div class="d-flex">
        <!-- TODO: user profile photo -->
        <div class="mr-3" style="height: 60px; width: 60px; border-radius: 50px; background-color: grey;">
        </div>
        <div class="meta">
            <div class="mt-1"><b><?= $post->user()->name ?></b> - No. <?= $post->idx ?></div>
            <div class="mt-1"><?= date('r', $post->createdAt) ?></div>
        </div>
    </div>

    <div class="fs-title mt-1">
        <h1><?= $post->title ?></h1>
    </div>

    <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
    <hr>
    <section class="buttons mt-3">
        <a class="btn btn-sm btn-primary"><?= ek('Like', '@T Like') ?></a>
        <a class="btn btn-sm btn-primary"><?= ek('Dislike', '@T Dislike') ?></a>
        <a class="btn btn-sm btn-primary" href="/?p=forum.post.edit&idx=<?= $post->idx ?>"><?= ek('Edit', '@T Edit') ?></a>
        <a class="btn btn-sm btn-danger" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>"><?= ek('Delete', '@T Delete') ?></a>
        <a class="btn btn-sm btn-primary" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ek('List', '@T list') ?></a>
    </section>

    <!-- FILES -->
    <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>

    <!-- Comment Box -->
    <div class="mt-3">
        <?php include widget('comment-edit/comment-edit-default', ['post' => $post, 'parent' => $post]) ?>
    </div>

    <?php if (!empty($post->comments())) { ?>
        <hr>
        <small><?= ek('Comment List', '@T Comment List') ?></small>

        <div class="comments mt-2">
            <?php foreach ($post->comments() as $comment) {  ?>
                <div class="mb-2" style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                    <?php include widget('comment-view/comment-view-default', ['comment' => $comment]) ?>
                    <div class="mt-2">
                        <?php include widget('comment-edit/comment-edit-default', ['post' => $post, 'parent' => $comment]) ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

</section>