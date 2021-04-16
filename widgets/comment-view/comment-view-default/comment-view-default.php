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
        <?php include widget('user/user-avatar', ['photoUrl' => $post->user()->shortProfile()['photoUrl'], 'size' => '50']) ?>
        <div>
            <b><?= $comment->user()->name !== '' ? $comment->user()->name : 'No name' ?></b>
            <div class="meta">
                <small>
                    No: <?= $comment->idx ?> -
                    Date: <?= date('r', $comment->createdAt) ?>
                </small>
            </div>
        </div>
    </div>

    <div class="mt-3" v-if="displayCommentForm[<?= $comment->idx ?>] !== 'update'">
        <div style="white-space: pre-wrap;"><?= $comment->content ?></div>
        <div class="files">
            <?php include widget('files-display/files-display-default', ['files' => $comment->files()]) ?>
        </div>
        <hr>
        <section class="d-flex buttons mt-3">
            <a class="btn btn-sm mr-2" v-if="displayCommentForm[<?= $comment->idx ?>] !== 'reply'" v-on:click="onCommentEditButtonClick(<?= $comment->idx ?>, 'reply')"><?= ek('Reply', '답변하기') ?></a>
            <a class="btn btn-sm mr-2" v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'" v-on:click="onCommentEditButtonClick(<?= $comment->idx ?>, '')"><?= ek('Cancel', '@T Cancel') ?></a>
            <vote-buttons n="<?= $comment->N ?>" y="<?= $comment->Y ?>" parent-idx="<?= $comment->idx ?>"></vote-buttons>
            <span class="flex-grow-1"></span>
            <?php if ($comment->isMine()) { ?>
                <a class="btn btn-sm btn-primary mr-1" v-on:click="onCommentEditButtonClick(<?= $comment->idx ?>, 'update')"><?= ek('Edit', '수정') ?></a>
                <a class="btn btn-sm btn-danger" onclick="onCommentDelete(<?= $comment->idx ?>)"><?= ek('Delete', '삭제') ?></a>
            <?php } ?>
        </section>


    </div>

    <!-- comment update form -->
    <comment-form root-idx="<?= $post->idx ?>" comment-idx='<?= $comment->idx ?>' v-if="displayCommentForm[<?= $comment->idx ?>] === 'update'"></comment-form>


</div>