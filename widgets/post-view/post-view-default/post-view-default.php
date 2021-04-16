<?php

/**
 * @name Default Post View
 */


$post = post()->current();
?>

<section class="p-3" style="border-radius: 16px; background-color: #f4f4f4;">
    <div class="pb-1" style="word-break: normal">
        <h3><?= $post->title ?></h3>
    </div>
    <?php include widget('forum/post-meta-default', ['post' => $post]) ?>
    <section class="post-body">
        <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
        <!-- FILES -->
        <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
        <hr>
        <div class="d-flex buttons mt-3">
            <div class="d-flex">
                <vote-buttons parent-idx="<?= $post->idx ?>" y="<?= $post->Y ?>" n="<?= $post->N ?>"></vote-buttons>
            </div>
            <span class="flex-grow-1"></span>
            <a class="btn btn-sm btn-primary mr-1" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?><?= lsub() ?>"><?= ek('List', '목록') ?></a>
            <?php if ($post->isMine() || admin()) { ?>
                <div>
                    <a class="btn btn-sm btn-primary" href="/?p=forum.post.edit&idx=<?= $post->idx ?>"><?= ek('Edit', '@T Edit') ?></a>
                    <a class="btn btn-sm btn-danger" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>"><?= ek('Delete', '@T Delete') ?></a>
                </div>
            <?php } ?>
        </div>
    </section>
    <div class="pt-2">
        <comment-form root-idx="<?= $post->idx ?>" parent-idx="<?= $post->idx ?>"></comment-form>
    </div>

    <?php if (!empty($post->comments())) { ?>
        <hr class="mb-1">
        <small class="text-muted"><?= count($post->comments()) . ' ' . ek('Comments', '@T Comments') ?></small>
        <div class="comments mt-2">
            <?php foreach ($post->comments() as $comment) {
                if (!$comment->deletedAt) { ?>
                    <div class="mt-2" style="margin-left: <?= ($comment->depth - 1) * 16 ?>px">
                        <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]) ?>
                    </div>

                    <!-- comment reply form -->
                    <comment-form root-idx="<?= $post->idx ?>" parent-idx='<?= $comment->idx ?>' v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'"></comment-form>
            <?php }
            } ?>
        </div>
    <?php } else { ?>
        <p class="mt-2 mb-0 text-muted"><small><?= ek('No comments yet ..', '@T No comments yet ..') ?></small></p>
    <?php } ?>
</section>


<script>
    mixins.push({
        data: function() {
            return {
                displayCommentForm: {
                    'a': 'apple'
                }
            };
        },
        created: function() {
            // console.log('created', this.displayCommentForm.a);
            request('app.version', {}, console.log, console.error);
            request('user.profile', {}, console.log, console.error);
        },
        methods: {
            onCommentEditButtonClick: function(idx, mode) {
                this.$set(this.displayCommentForm, idx, mode);
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
            if (this.commentIdx) {
                const self = this;
                request('comment.get', {
                    idx: this.commentIdx
                }, function(res) {
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
            '       <button class="btn btn-primary mr-4" type="button"><?= ek('Photo', '@T Photo') ?></button>' +
            '       <input class="position-absolute top left fs-lg opacity-0" type="file" v-on:change="onFileChange($event)">' +
            '   </div>' +
            '   <textarea rows="1" class="form-control" v-model="form.content"></textarea>' +
            '   <div class="d-flex" v-if="form.content || uploadedFiles.length">' +
            '      <button class="btn btn-primary ml-2" type="submit"><?= ek('Submit', '@T Submit') ?></button>' +
            '      <button class="btn btn-primary ml-2" type="button" v-on:click="onCommentEditCancelButtonClick()" v-if="commentIdx || parentIdx !== rootIdx">Cancel</button>' +
            '   </div>' +
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
                    file, {},
                    function(res) {
                        console.log("success: res.path: ", res, res.path);
                        self.form.files = addByComma(self.form.files, res.idx);
                        self.uploadedFiles.push(res);
                    },
                    alert,
                    function(p) {
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

                request(route, this.form, function() {
                    location.reload();
                }, alert);
            },
            onCommentEditCancelButtonClick: function() {
                console.log('onCommentEditCancelButtonClick', this.commentIdx);
                this.$parent.displayCommentForm[this.commentIdx ?? this.parentIdx] = '';
            },
            onFileDelete(idx) {
                const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
                if (re === false) return;
                const self = this;
                request('file.delete', {
                    idx: idx
                }, function(res) {
                    self.uploadedFiles = self.uploadedFiles.filter(function(v, i, ar) {
                        return v.idx !== res.idx;
                    });
                    self.form.files = deleteByComma(self.form.files, res.idx);
                }, alert);
            }
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
            '<?= ek('Like', '@T Like') ?> <span class="badge badge-success badge-pill" v-if="Y != \'0\'">{{ Y }}</span></a>' +
            '<a class="btn btn-sm mr-2" @click="onVote(\'N\')" style="color: red">' +
            '<?= ek('Dislike', '@T Dislike') ?> <span  class="badge badge-danger badge-pill" v-if="N != \'0\'">{{ N }}</span></a>' +
            '</div>',
        methods: {
            onVote(choice) {
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