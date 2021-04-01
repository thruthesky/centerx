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
    <div class="meta">
        No. <?= $post->idx ?>
        User. <?= $post->user()->name ?>
        Date: <?= date('r', $post->createdAt) ?>
    </div>
    <hr>
    <div class="content box mt-3">
        <?= $post->content ?>
    </div>
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
        <div class="comments">
            <?php foreach ($post->comments() as $comment) {  ?>
                <div class="mb-2" style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                    <div class="p-2" style="border-radius: 10px; background-color: #e0e0e0">
                        No.: <?= $comment->idx ?>
                        <div>
                            <?= $comment->content ?>
                        </div>
                        <div class="files">
                            <?php foreach ($comment->files() as $file) { ?>
                                <img class="w-100" src="<?= $file->url ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mt-2">
                        <?php include widget('comment-edit/comment-edit-default', ['post' => $post, 'parent' => $comment]) ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

</section>