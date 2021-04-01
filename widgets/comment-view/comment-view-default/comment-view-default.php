<?php
$o = getWidgetOptions();

/**
 * @var Comment|Post $parent
 */
$comment = $o['comment'];

?>

<div class="p-2" style="border-radius: 10px; background-color: #e0e0e0">
    <?= $comment->user()->name ?>
    <div class="meta">
        <small>
            No: <?= $comment->idx ?> -
            Date: <?= date('r', $post->createdAt) ?>
        </small>
    </div>
    <div class="mt-3" style="white-space: pre-wrap;"><?= $comment->content ?></div>
    <div class="files">
        <?php include widget('files-display/files-display-default', ['files' => $comment->files()]) ?>
    </div>
</div>