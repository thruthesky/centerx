<?php

/**
 * @name All In One: Create, List, View
 */

$o = getWidgetOptions();
$posts = $o['posts'];


?>
<div class="d-none" :class="{'d-block': showPostForm}">
    <?php include widget('post-edit/post-edit-default'); ?>
</div>
<section class="post-list-all-in-one">

    <?php
    if (count($posts)) {
        foreach ($posts as $post) {
            $_user = user($post->userIdx);
    ?>
            <div class="w-100 p-2 rounded mt-3" style="background-color: #f4f4f4;">
                <div class="post-view-header d-flex">
                    <div>
                        <?php include widget('avatar/avatar', ['photoUrl' => $_user->photoUrl]) ?>
                    </div>
                    <a href="<?= $post->url ?>">
                        <div class="font-weight-bold">No. <?= $post->idx ?> <?= $post->title ?></div>
                        <div class="mt-2">
                            [<?= category($post->categoryIdx)->id ?>] -
                            <?= ln('no_of_views') ?>: <?= $post->noOfViews ?> -
                            <?= $post->shortDate ?>
                        </div>
                    </a>
                </div>
                <div class="content p-2 bg-white">
                    <?= nl2br($post->content) ?>
                </div>
                <div class="d-flex align-items-center buttons mt-2">
                    <div class="d-flex">
                        <vote-buttons parent-idx="<?= $post->idx ?>" y="<?= $post->Y ?>" n="<?= $post->N ?>" text-like="<?= ln('like') ?>" text-dislike="<?= ln('dislike') ?>"></vote-buttons>
                        <?php if ($post->isMine() == false) { ?><a class="btn btn-sm mr-2" href="<?= messageSendUrl($post->userIdx) ?>"><?= ln('send_message') ?></a><?php } ?>
                    </div>
                    <span class="flex-grow-1"></span>
                    <a class="btn btn-sm mr-1" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ln('list') ?></a>

                    <?php if ($post->isMine() || admin()) { ?>
                        <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" no-caret>
                            <template #button-content>
                                <i class="fa fa-ellipsis-h dark fs-md"></i><span class="sr-only">Search</span>
                            </template>
                            <b-dropdown-item href="<?= postEditUrl(postIdx: $post->idx) ?>"><?= ln('edit') ?></b-dropdown-item>
                            <b-dropdown-item href="<?= postDeleteUrl($post->idx) ?>" onclick="return confirm('<?= ln('confirm_delete') ?>')">
                                <div class="red"><?= ln('delete') ?></div>
                            </b-dropdown-item>
                            <?php if (admin()) { ?>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-group id="dropdown-group-1" header="Admin">
                                    <b-dropdown-item href="<?= postMessagingUrl($post->idx) ?>"><?= ln('admin push') ?></b-dropdown-item>
                                </b-dropdown-group>
                            <?php } ?>
                        </b-dropdown>
                    <?php } ?>
                </div>
                <div class="files">
                    <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
                </div>
                <div class="mt-3">
                    <comment-form root-idx="<?= $post->idx ?>" parent-idx="<?= $post->idx ?>" text-submit="<?= ln('submit') ?>" text-cancel="<?= ln('cancel') ?>">
                    </comment-form>
                </div>
                <div class="comments mt-3">
                    <?php foreach ($post->comments() as $comment) { ?>
                        <div class="mb-2 p-1 rounded" style="margin-left: <?= $comment->depth * 16 ?>px; background-color: #e0e0e0;">
                            <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]); ?>
                            <comment-form root-idx="<?= $post->idx ?>" parent-idx="<?= $comment->idx ?>" text-submit="<?= ln('submit') ?>" text-cancel="<?= ln('cancel') ?>" v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'">
                            </comment-form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    } else { ?>
        <?php include widget('post-list/empty-post-listt'); ?>
    <?php } ?>
</section>

<script>
    mixins.push({
        data: function() {
            return {
                displayCommentForm: {}
            };
        },
        methods: {
            onCommentEditButtonClick: function(idx, mode) {
                this.$set(this.displayCommentForm, idx, mode);
            },
        }
    });
</script>

<?php js('/etc/js/vue-js-components/comment-form.js', 1) ?>