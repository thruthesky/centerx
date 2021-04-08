<?php
$o = getWidgetOptions();

/**
 * @var Comment|Post $parent
 */
$post = $o['post'];
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

    <div class="mt-3" id="comment-view-<?= $comment->idx ?>">
        <div style="white-space: pre-wrap;"><?= $comment->content ?></div>
        <div class="files">
            <?php include widget('files-display/files-display-default', ['files' => $comment->files()]) ?>
        </div>
        <hr>
        <section class="buttons mt-3">
            <a class="btn btn-sm btn-primary"><?= ek('Reply', '답변하기') ?></a>
            <a class="btn btn-sm btn-primary"><?= ek('Like', '@T Like') ?></a>
            <a class="btn btn-sm btn-primary"><?= ek('Dislike', '@T Dislike') ?></a>
            <?php if ($comment->isMine()) { ?>
                <a class="btn btn-sm btn-primary" onclick="showCommentEditForm(<?= $comment->idx ?>)"><?= ek('Edit', '수정') ?></a>
                <a class="btn btn-sm btn-danger" onclick="onCommentDelete(<?= $comment->idx ?>)"><?= ek('Delete', '삭제') ?></a>
            <?php } ?>
        </section>
    </div>


</div>

<script>
    // function showCommentEditForm(id) {
    //     document.getElementById("comment-view-" + id).style.display = "none";
    //     document.getElementById("comment-reply-" + id).style.display = "none";
    //     document.getElementById("comment-edit-" + id).style.display = "block";
    // }
    //
    // function hideCommentEditForm(id) {
    //     document.getElementById("comment-view-" + id).style.display = "block";
    //     document.getElementById("comment-reply-" + id).style.display = "block";
    //     document.getElementById("comment-edit-" + id).style.display = "none";
    // }

    function onCommentDelete(idx) {
        const re = confirm('Are you sure you want to delete Comment no. ' + idx + '?');
        if (re === false) return;
        axios.post('/index.php', {
                sessionId: '<?= login()->sessionId ?>',
                route: 'comment.delete',
                idx: idx,
            })
            .then(function(res) {
                console.log('comment deleted, ', res);
                location.reload();
            })
            .catch(alert);
    }
</script>