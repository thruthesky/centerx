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

                    <comment-form root-idx="<?= $post->idx ?>" comment='<?= json_encode($comment) ?>'></comment-form>
            <?php }
            } ?>
        </div>
    <?php } ?>

</section>


<script>
    Vue.component('comment-form', {
        props: ['rootIdx', 'parentIdx', 'comment'],
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
        template: '<form class="d-flex mt-2" v-on:submit.prevent="commentFormSubmit">' +
            '<textarea class="form-control" v-model="form.content"></textarea>' +
            '<input class="btn btn-primary ml-2" type="submit">' +
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
            }
        }
    });
</script>