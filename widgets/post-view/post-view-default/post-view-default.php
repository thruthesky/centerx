<?php
/**
 * @name Default Post View
 */
$post = post()->current();
if ( $post->hasError ) {
    $_uri = urldecode($_SERVER['REQUEST_URI']);
    return displayWarning("접속 경로 '$_uri' 에 해당하는 글이 없습니다.");

}
$comments = $post->comments();
?>


    <section class="post-view-default p-3 mb-5" style="border-radius: 16px; background-color: #f4f4f4;">
        <div class="pb-1" style="word-break: normal">
            <h3><?= $post->title ?></h3>
        </div>
        <?php include widget('post-meta/post-meta-default', ['post' => $post]) ?>
        <section class="post-body">
            <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
            <!-- FILES -->
            <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
            <hr class="my-1">
            <div class="d-flex align-items-center buttons mt-2">
                <div class="d-flex">
                    <vote-buttons
                            parent-idx="<?= $post->idx ?>" y="<?= $post->Y ?>" n="<?= $post->N ?>"
                            text-like="<?=ln('like')?>"
                            text-dislike="<?=ln('dislike')?>"
                    ></vote-buttons>
                    <?php if ( $post->isMine() == false ) {?><a class="btn btn-sm mr-2" href="<?=messageSendUrl($post->userIdx)?>"><?=ln('send_message')?></a><?php } ?>
                </div>
                <span class="flex-grow-1"></span>
                <a class="btn btn-sm mr-1" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?=ln('list')?></a>

                <?php if ($post->isMine() || admin()) { ?>
                    <b-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret>
                        <template #button-content>
                            <i class="fa fa-ellipsis-h dark fs-md"></i><span class="sr-only">Search</span>
                        </template>
                        <b-dropdown-item href="<?=postEditUrl(postIdx: $post->idx)?>"><?=ln('edit')?></b-dropdown-item>
                        <b-dropdown-item href="<?=postDeleteUrl($post->idx)?>"  onclick="return confirm('<?=ln('confirm_delete')?>')"><div class="red"><?=ln('delete')?></div></b-dropdown-item>
                        <?php if (admin()) { ?>
                            <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-group id="dropdown-group-1" header="Admin">
                        <b-dropdown-item href="<?=postMessagingUrl($post->idx)?>"><?=ln('admin push')?></b-dropdown-item>
                        </b-dropdown-group>
                        <?php } ?>
                    </b-dropdown>
                <?php } ?>


            </div>
        </section>
        <div class="pt-2">
            <!--
                if text-photo is not set, then camera icon will be used.
            -->
            <comment-form
                    root-idx="<?= $post->idx ?>"
                    parent-idx="<?= $post->idx ?>"
                    text-submit="<?=ln('submit')?>"
                    text-cancel="<?=ln('cancel')?>"
            ></comment-form>
        </div>

        <?php if ( $comments ) { ?>
            <hr class="mb-1">
            <small class="text-muted"><?= count($comments) . ' ' . ln('comments') ?></small>
            <div class="comments mt-2">
                <?php foreach ($comments as $comment) {
                    if (!$comment->deletedAt) { ?>
                        <div class="mt-2" style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                            <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]) ?>
                            <!-- comment reply form -->
                            <comment-form root-idx="<?= $post->idx ?>"
                                          parent-idx='<?= $comment->idx ?>'
                                          text-submit="<?=ln('submit')?>"
                                          text-cancel="<?=ln('cancel')?>"
                                          v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'"
                            ></comment-form>
                        </div>
                    <?php }
                } ?>
            </div>
        <?php } else { ?>
            <p class="mt-2 mb-0 text-muted"><small><?= ln('no_comments_yet') ?></small></p>
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
<?php js('/etc/js/vue-js-components/vote-buttons.js', 1) ?>
<?php js('/etc/js/vue-js-components/comment-form.js', 1) ?>
<?php js('/etc/js/vue-js-components/progress-bar.js', 1) ?>