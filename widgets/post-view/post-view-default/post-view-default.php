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

    <section class="post-body">
        <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
        <hr>
        <div class="buttons mt-3">
            <a class="btn btn-sm btn-primary"><?= ek('Like', '@T Like') ?></a>
            <a class="btn btn-sm btn-primary"><?= ek('Dislike', '@T Dislike') ?></a>
            <?php if ($post->isMine()) { ?>
                <a class="btn btn-sm btn-primary" href="/?p=forum.post.edit&idx=<?= $post->idx ?>"><?= ek('Edit', '@T Edit') ?></a>
                <a class="btn btn-sm btn-danger" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>"><?= ek('Delete', '@T Delete') ?></a>
            <?php } ?>
            <a class="btn btn-sm btn-primary" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ek('List', '@T list') ?></a>
        </div>

        <!-- FILES -->
        <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>

    </section>


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
            request('app.version', {}, console.log, console.error);
            request('user.profile', {}, console.log, console.error);
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
                    files: '', // a string of file idx(es)
                },
                percent: 0,
                uploadedFiles: [], // an array of file objects
            }
        },
        created: function() {
            console.log('component: comment-form, created', this.commentIdx);
            if ( this.commentIdx ) {
                const self = this;
                request('comment.get', {idx: this.commentIdx}, function(res) {
                    self.form.content = res.content;
                    // self.form = res;
                    self.uploadedFiles = res.files;
                }, alert);
            }
        },
        template: '<form class="mt-2" v-on:submit.prevent="commentFormSubmit">' +
            '<input type="hidden" name="files" v-model="form.files">' +
            '<section class="d-flex">' +
            '   <div class="position-relative overflow-hidden">' +
            '       <button class="btn btn-primary mr-5" type="button">Photo</button>' +
            '       <input class="position-absolute top left fs-lg opacity-0" type="file" v-on:change="onFileChange($event)">' +
            '   </div>' +
            '   <textarea class="form-control" v-model="form.content"></textarea>' +
            '   <input class="btn btn-primary ml-2" type="submit">' +
            '   <button class="btn btn-primary ml-2" type="button" v-on:click="onCommentEditCancelButtonClick()" v-if="commentIdx">Cancel</button>' +
            '</section>' +
            '<div class="container photos">' +
            '   <div class="row">' +
            '       <div class="col-3 col-sm-2 photo" v-for="file in uploadedFiles" :key="file.idx">' +
            '           <div class="position-relative">' +
            '               <img class="w-100" :src="file.url">' +
            '               <div class="position-absolute top left font-weight-bold" v-on:click="onFileDelete(file.idx)">[X]</div>' +
            '           </div>' +
            '       </div>' +
            '   </div>' +
            '</div>' +
            '</form>',
        methods: {
            onFileChange: function(event) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }
                const file = event.target.files[0];
                const self = this;
                fileUpload(
                    file,
                    {},
                    function (res) {
                        console.log("success: res.path: ", res, res.path);
                        self.form.files = addByComma(self.form.files, res.idx);
                        self.uploadedFiles.push(res);
                    },
                    alert,
                    function (p) {
                        console.log("pregoress: ", p);
                        this.percent = p;
                    }
                );
            },
            commentFormSubmit: function() {
                var route;
                if (this.commentIdx) {
                    route = 'comment.update';
                    this.form.idx = this.commentIdx;
                } else {
                    route = 'comment.create';
                    this.form.parentIdx = this.parentIdx;
                }

                console.log('form', this.form);

                request(route, this.form, function() { location.reload(); }, alert);
            },
            onCommentEditCancelButtonClick: function() {
                console.log('onCommentEditCancelButtonClick', this.commentIdx);
                this.$parent.displayCommentForm[this.commentIdx] = false;
            },
            onFileDelete(idx) {
                const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
                if ( re === false ) return;
                const self = this;
                request('file.delete', {idx: idx}, function(res) {
                    self.uploadedFiles = self.uploadedFiles.filter(function(v, i, ar) {
                        return v.idx !== res.idx;
                    });
                    self.form.files = deleteByComma(self.form.files, res.idx);
                }, alert);
            }
        }
    });
</script>