<?php
/**
 * @name Default Post View
 */

$op = getWidgetOptions();

$post = $op['post'];
// $post = post()->current();

if ( $post->hasError ) {
    $_uri = urldecode($_SERVER['REQUEST_URI']);
    return displayWarning("접속 경로 '$_uri' 에 해당하는 글이 없습니다.");

}
$comments = $post->comments();
?>
    <section class="post-view-default p-3 mb-3 rounded" style="background-color: #f4f4f4;">
        <div class="pb-1" style="word-break: normal">
            <h4><?= $post->title ?></h4>
        </div>
        <?php include widget('post-meta/post-meta-default', ['post' => $post]) ?>
        <section class="post-body">
            <div class="content box my-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
            <!-- FILES -->
            <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
            <hr class="my-2">
            <!-- BUTTONS -->
            <?php include widget('post-buttons/post-buttons-default', ['post' => $post]); ?>
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
                        <div class="mt-2 " style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
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