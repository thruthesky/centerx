<?php

/**
 * @name Default Post View
 */


$post = post()->current();


?>

<section class="p-3" style="border-radius: 10px; background-color: #f4f4f4;">
    <div class="title">
        <h1><?= $post->title ?></h1>
    </div>
    <small class="meta">
        No. <?= $post->idx ?>
        User. <?= $post->user()->name ?>
        Date: <?= date('r', $post->createdAt) ?>
    </small>
    <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
    <hr>
    <section class="buttons mt-3">
        <a class="btn btn-sm btn-secondary" href="/?p=forum.post.edit&idx=<?= $post->idx ?>">Edit</a>
        <a class="btn btn-sm btn-secondary" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>">Delete</a>
        <a class="btn btn-sm btn-secondary" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>">List</a>
    </section>


    <div class="files mt-3">
        <?php foreach ($post->files() as $file) { ?>
            <img class="w-100" src="<?= $file->url ?>">
        <?php } ?>
    </div>

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