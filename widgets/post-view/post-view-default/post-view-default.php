<?php

/**
 * @name Default Post View
 */


$post = post()->current();
?>

<section class="p-3" style="border-radius: 10px; background-color: #f4f4f4;">
    <div class="d-flex">
        <!-- TODO: user profile photo -->
        <div class="mr-3" style="height: 60px; width: 60px; border-radius: 50px; background-color: grey;">
        </div>
        <div class="meta">
            <div class="mt-1"><b><?= $post->user()->name ?></b> - No. <?= $post->idx ?></div>
            <div class="mt-1"><?= date('r', $post->createdAt) ?></div>
        </div>
    </div>

    <div class="mt-2">
        <h1 style="word-break: break-all"><?= $post->title ?></h1>
    </div>

    <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
    <hr>
    <section class="buttons mt-3">
        <a class="btn btn-sm btn-primary"><?= ek('Like', '@T Like') ?></a>
        <a class="btn btn-sm btn-primary"><?= ek('Dislike', '@T Dislike') ?></a>
        <?php if ($post->isMine()) { ?>
            <a class="btn btn-sm btn-primary" href="/?p=forum.post.edit&idx=<?= $post->idx ?>"><?= ek('Edit', '@T Edit') ?></a>
            <a class="btn btn-sm btn-danger" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>"><?= ek('Delete', '@T Delete') ?></a>
        <?php } ?>
        <a class="btn btn-sm btn-primary" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ek('List', '@T list') ?></a>
    </section>


    <!-- FILES -->
    <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>



    <comment-form root-idx="<?= $post->idx ?>" parent-idx="<?= $post->idx ?>"></comment-form>


    <?php #include widget('comment-edit/comment-edit-default', ['post' => $post, 'parent' => $post]) 
    ?>

    <?php if (!empty($post->comments())) { ?>
        <hr>
        <small><?= ek('Comment List', '@T Comment List') ?></small>
        <div class="comments mt-2">
            <?php foreach ($post->comments() as $comment) {
                if (!$comment->deletedAt) { ?>
                    <div class="mt-2" style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                        <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]) ?>
                    </div>
{{ displayCommentForm }}
                    <comment-form root-idx="<?= $post->idx ?>" comment-idx='<?= $comment->idx ?>'
                                  v-if="displayCommentForm[<?=$comment->idx?>]"></comment-form>
            <?php }
            } ?>
        </div>
    <?php } ?>

</section>


<script>
    mixins.push({
        data: function() {
            return {
                displayCommentForm: {'a': 'apple'}
            };
        },
        created: function() {
          console.log('created', this.displayCommentForm.a);
        },
       methods: {
           onCommentEditButtonClick: function(idx) {
               this.$set(this.displayCommentForm, idx, true);
           },
       }
    });
    Vue.component('comment-form', {
        props: ['rootIdx', 'parentIdx', 'commentIdx'],
        data: function() {
            return {
                form: {
                    session_id: '<?= login()->session_id ?>',
                    p: 'forum.comment.edit.submit',
                    rootIdx: this.rootIdx,
                    content: this.comment ? this.comment.content : '',
                }
            }
        },
        created: function() {
            console.log('component: comment-form, created', this.commentIdx);
            if ( this.commentIdx ) {
                const self = this;
                request('comment.get', {idx: this.commentIdx}, function(res) {
                    self.form.content = res.content;
                }, alert);
            }
        },
        template: '<form class="d-flex mt-2" v-on:submit.prevent="commentFormSubmit">' +
            '<textarea class="form-control" v-model="form.content"></textarea>' +
            '<input class="btn btn-primary ml-2" type="submit">' +
            '<button class="btn btn-primary ml-2" type="button" v-on:click="onCommentEditCancelButtonClick()">Cancel</button>' +
            '</form>',
        methods: {
            commentFormSubmit: function() {

                if (this.comment) {
                    var comment = JSON.parse(this.comment);
                    this.form.idx = comment.idx;
                } else {
                    this.form.parentIdx = this.parentIdx;
                }

                console.log('form', this.form);

                axios.post('/index.php', this.form)
                    .then(function(res) {
                        console.log('create success: ', res);
                    });
            },
            onCommentEditCancelButtonClick: function() {
                console.log('onCommentEditCancelButtonClick', this.commentIdx);
                this.$parent.displayCommentForm[this.commentIdx] = false;
            }
        }
    });
</script>