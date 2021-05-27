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
    ?>
            <div class="w-100 p-3 rounded mt-3" style="background-color: #f4f4f4;">
                <div class="post-view-header d-flex">
                    <div>
                        <?php include widget('avatar/avatar', ['photoUrl' => $post->user()->photoUrl, 'size' => 55]) ?>
                    </div>
                    <a href="<?= $post->url ?>">
                        <div class="font-weight-bold align-middle">
                            <h5 class="d-inline-block m-0">
                                <span class="mr-2"><small>No. <?= $post->idx ?></small></span>
                                <?= $post->title ?>
                            </h5>
                        </div>
                        <div class="mt-2">
                            <span class="font-weight-bold"><?= $post->user()->nicknameOrName ?></span> -
                            <span class="badge badge-secondary text-uppercase"><?= category($post->categoryIdx)->id ?></span> -
                            <?= ln('no_of_views') ?>: <?= $post->noOfViews ?> -
                            <?= $post->shortDate ?>
                        </div>
                    </a>
                </div>
                <div class="content mt-3 p-2 bg-white">
                    <?= nl2br($post->content) ?>
                </div>
                <?php if (!empty($post->files())) { ?>
                    <div class="files mt-3">
                        <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
                    </div>
                <?php } ?>
                <div class="buttons">
                    <?php include widget('post-buttons/post-buttons-default', ['post' => $post]); ?>
                </div>
                <div class="mt-3">
                    <comment-form root-idx="<?= $post->idx ?>" parent-idx="<?= $post->idx ?>" text-submit="<?= ln('submit') ?>" text-cancel="<?= ln('cancel') ?>">
                    </comment-form>
                </div>
                <?php if (!empty($post->comments())) { ?>
                    <hr class="mb-1">
                    <small class="text-muted"><?= count($post->comments()) . ' ' . ln('comments') ?></small>
                    <div class="comments mt-2">
                        <?php foreach ($post->comments() as $comment) {
                            if (!$comment->deletedAt) { ?>
                                <div class="mt-2 " style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                                    <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]) ?>
                                    <!-- comment reply form -->
                                    <comment-form root-idx="<?= $post->idx ?>" parent-idx='<?= $comment->idx ?>' text-submit="<?= ln('submit') ?>" text-cancel="<?= ln('cancel') ?>" v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'"></comment-form>
                                </div>
                        <?php }
                        } ?>
                    </div>
                <?php } else { ?>
                    <p class="mt-2 mb-0 text-muted"><small><?= ln('no_comments_yet') ?></small></p>
                <?php } ?>
            </div>
        <?php }
    } else { ?>
        <?php include widget('post-list/empty-post-list'); ?>
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