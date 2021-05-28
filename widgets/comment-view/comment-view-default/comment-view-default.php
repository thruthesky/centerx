<?php
$o = getWidgetOptions();

/**
 * @var CommentTaxonomy|PostTaxonomy $post
 */
$post = $o['post'];
/**
 * @var CommentTaxonomy $comment
 */
$comment = $o['comment'];

$avatarPopoverId = "user-avatar-" . $comment->idx;
$usernamePopoverId = "user-name-" . $comment->idx;
?>

<div class="comment-view-default p-3" style="border-radius: 10px; background-color: #e0e0e0">
    <div class="d-flex">
        <div id="<?= $avatarPopoverId ?>" class="pointer" @click="openPopover('<?= $avatarPopoverId ?>')" tabindex="0">
            <?php include widget('user/user-avatar', ['photoUrl' => $post->user()->shortProfile()['photoUrl'], 'size' => '50']) ?>
        </div>
        <div>
            <b id="<?= $usernamePopoverId ?>" class="pointer block" @click="openPopover('<?= $usernamePopoverId ?>')" tabindex="0">
                <?= $comment->user()->nicknameOrName ?>
            </b>
            <div class="meta text-muted">
                <small>
                    No. <?= $comment->idx ?> •
                    <?= ln('date') ?>: <?= $post->shortDate ?>
                </small>
            </div>
        </div>
    </div>

    <div class="mt-3" v-if="displayCommentForm[<?= $comment->idx ?>] !== 'update'">
        <div style="white-space: pre-wrap;"><?= $comment->content ?></div>
        <div class="files">
            <?php include widget('files-display/files-display-default', ['files' => $comment->files()]) ?>
        </div>
        <hr class="my-1">
        <section class="d-flex buttons mt-2">
            <a class="btn btn-sm mr-2" v-if="displayCommentForm[<?= $comment->idx ?>] !== 'reply'" v-on:click="onCommentEditButtonClick(<?= $comment->idx ?>, 'reply')"><?= ln('reply') ?></a>
            <a class="btn btn-sm mr-2" v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'" v-on:click="onCommentEditButtonClick(<?= $comment->idx ?>, '')"><?= ln('cancel') ?></a>
            <vote-buttons n="<?= $comment->N ?>" y="<?= $comment->Y ?>" parent-idx="<?= $comment->idx ?>" text-like="<?= ln('like') ?>" text-dislike="<?= ln('dislike') ?>"></vote-buttons>
            <?php if (!$comment->isMine()) { ?><a class="btn btn-sm mr-2" href="<?= messageSendUrl($comment->userIdx) ?>"><?= ln('send_message') ?></a><?php } ?>
            <span class="flex-grow-1"></span>


            <?php if ($comment->isMine()) { ?>
                <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" no-caret>
                    <template #button-content>
                        <i class="fa fa-ellipsis-h dark fs-md"></i><span class="sr-only">Search</span>
                    </template>
                    <b-dropdown-item v-on:click="onCommentEditButtonClick(<?= $comment->idx ?>, 'update')"><?= ln('edit') ?></b-dropdown-item>
                    <b-dropdown-item onclick="onCommentDelete(<?= $comment->idx ?>)">
                        <div class="red"><?= ln('delete') ?></div>
                    </b-dropdown-item>
                </b-dropdown>

            <?php } ?>

        </section>


    </div>

    <!-- comment update form -->
    <comment-form root-idx="<?= $post->idx ?>" comment-idx="<?= $comment->idx ?>" text-submit="<?= ln('submit') ?>" text-cancel="<?= ln('cancel') ?>" v-if="displayCommentForm[<?= $comment->idx ?>] === 'update'"></comment-form>


</div>

<script>
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

<forum-popup-menu :id="'<?= $avatarPopoverId ?>'"></forum-popup-menu>
<forum-popup-menu :id="'<?= $usernamePopoverId ?>'"></forum-popup-menu>

<?php js(HOME_URL . 'etc/js/vue-js-components/user-popup-menu.js') ?>
<?php js('/etc/js/vue-js-components/vote-buttons.js', 1) ?>