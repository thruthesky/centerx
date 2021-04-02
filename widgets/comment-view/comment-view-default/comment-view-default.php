<?php
$o = getWidgetOptions();

/**
 * @var Comment|Post $parent
 */
$comment = $o['comment'];

?>

<div class="p-3" style="border-radius: 10px; background-color: #e0e0e0">

    <div class="d-flex">
        <!-- TODO: user profile photo -->
        <div class="mr-3" style="height: 50px; width: 50px; border-radius: 50px; background-color: grey;">
        </div>
        <div>
            <b><?= $comment->user()->name ?></b>
            <div class="meta">
                <small>
                    No: <?= $comment->idx ?> -
                    Date: <?= date('r', $comment->createdAt) ?>
                </small>
            </div>
        </div>
    </div>
    <div class="mt-3" style="white-space: pre-wrap;"><?= $comment->content ?></div>
    <div class="files">
        <?php include widget('files-display/files-display-default', ['files' => $comment->files()]) ?>
    </div>
    <section class="buttons mt-3">
        <a class="btn btn-sm btn-primary"><?= ek('Like', '@T Like') ?></a>
        <a class="btn btn-sm btn-primary"><?= ek('Dislike', '@T Dislike') ?></a>
        <?php if ($comment->isMine()) { ?>
            <a class="btn btn-sm btn-primary" href=""><?= ek('Edit', '@T Edit') ?></a>
            <a class="btn btn-sm btn-danger"><?= ek('Delete', '@T Delete') ?></a>
        <?php } ?>
    </section>

    <!-- EDIT  -->
    <div class="mt-2"></div>
    <?php include widget('comment-edit/comment-edit-default', ['post' => $post, 'parent' => $post, 'comment' => $comment]) ?>
</div>