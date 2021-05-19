<?php

/**
 * @name Default Post View
 */


$post = post()->current();
$comments = $post->comments();
?>

<section class="post-view-default p-3 mb-5" style="border-radius: 16px; background-color: #f4f4f4;">
    <div class="pb-1" style="word-break: normal">
        <h3><?= $post->title ?></h3>
    </div>
    <?php include widget('forum/post-meta-default', ['post' => $post]) ?>
    <section class="post-body">
        <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
        <!-- FILES -->
        <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
        <hr class="my-1">
        <div class="d-flex buttons mt-2">
            <div class="d-flex">
                <vote-buttons parent-idx="<?= $post->idx ?>" y="<?= $post->Y ?>" n="<?= $post->N ?>"></vote-buttons>
                <a class="btn btn-sm mr-2" href="<?=messageSendUrl($post->userIdx)?>"><?=ln('send_message')?></a>
            </div>
            <span class="flex-grow-1"></span>
            <a class="btn btn-sm mr-1" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ek('List', '목록') ?></a>
            <?php if ($post->isMine() || admin()) { ?>
                <div>
                    <a class="btn btn-sm" href="/?p=forum.post.edit&idx=<?= $post->idx ?>"><?= ek('Edit', '수정') ?></a>
                    <a class="btn btn-sm" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>" style="color: red" onclick="return confirm('<?= ek('Delete Post?', '@T Delete Post') ?>')">
                        <?= ek('Delete', '삭제') ?>
                    </a>
                </div>
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
        <small class="text-muted"><?= count($comments) . ' ' . ek('Comments', '개의 코멘트') ?></small>
        <div class="comments mt-2">
            <?php foreach ($comments as $comment) {
                if (!$comment->deletedAt) { ?>
                    <div class="mt-2" style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                        <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]) ?>
                        <!-- comment reply form -->
                        <comment-form root-idx="<?= $post->idx ?>"
                                      parent-idx='<?= $comment->idx ?>'
                                      text-photo="<?=ln('photo')?>"
                                      text-submit="<?=ln('submit')?>"
                                      text-cancel="<?=ln('cancel')?>"
                                      v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'"
                        ></comment-form>
                    </div>
            <?php }
            } ?>
        </div>
    <?php } else { ?>
        <p class="mt-2 mb-0 text-muted"><small><?= ek('No comments yet ..', '작성된 코멘트가 없습니다.') ?></small></p>
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
<script>
    Vue.component('vote-buttons', {
        props: ['parentIdx', 'y', 'n'],
        data: function() {
            return {
                Y: this.y,
                N: this.n,
            }
        },
        template: '<div class="d-flex">' +
            '<a class="btn btn-sm mr-2" @click="onVote(\'Y\')" style="color: green">' +
            '<?= ek('Like', '좋아요') ?> <span class="badge badge-success badge-pill" v-if="Y != \'0\'">{{ Y }}</span></a>' +
            '<a class="btn btn-sm mr-2" @click="onVote(\'N\')" style="color: red">' +
            '<?= ek('Dislike', '싫어요') ?> <span  class="badge badge-danger badge-pill" v-if="N != \'0\'">{{ N }}</span></a>' +
            '</div>',
        methods: {
            onVote: function(choice) {
                const self = this;
                request('post.vote', {
                    idx: this.parentIdx,
                    choice: choice
                }, function(res) {
                    self.N = res['N'];
                    self.Y = res['Y'];
                }, alert);
            },
        }
    });
</script>
<?php js('/etc/js/vue-js-components/comment-form.js', 1) ?>
<?php js('/etc/js/vue-js-components/progress-bar.js', 1) ?>