<?php

/**
 * @name Default Post Edit
 */

$post = post(in(IDX, 0));

if (in(CATEGORY_ID)) {
    $category = category(in(CATEGORY_ID));
} else if (in(IDX)) {
    $category = category($post->v(CATEGORY_IDX));
} else {
    jsBack('잘못된 접속입니다.');
}
?>
<section class="p3" style="background-color: #efefef;">
    <div id="post-edit-default" class="p-5">
        <form action="/" method="POST">
            <input type="hidden" name="p" value="forum.post.edit.submit">
            <input type="hidden" name="returnTo" value="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
            <input type="hidden" name="files" v-model="files">
            <input type="hidden" name="<?= CATEGORY_ID ?>" value="<?= $category->v(ID) ?>">
            <input type="hidden" name="<?= IDX ?>" value="<?= $post->idx ?>">
            <div>
                <?= ek('Title', '@T Title') ?>:
                <input class="form-control" type="text" name="<?= TITLE ?>" value="<?= $post->v(TITLE) ?>">
            </div>
            <div class="mt-3">
                <?= ek('Content', '@T Content') ?>:
                <textarea style="min-height: 150px" class="form-control" type="text" name="<?= CONTENT ?>" value="<?= $post->v(CONTENT) ?>"></textarea>
            </div>
            <!-- Buttons. TODO: progress bar -->
            <div class="mt-3 d-flex">
                <!-- UPLOAD BUTTON -->
                <div style="width: 100px" class="position-relative overflow-hidden">
                    <!-- TODO: camera icon -->
                    <button class="btn btn-primary" type="button">Upload</button>
                    <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" @change="onFileChange($event)" />
                </div>
                <div class="flex-grow-1"></div>
                <!-- SUBMIT BUTTON -->
                <button class="btn btn-primary" type="submit"><?= ek('Submit', '@T Submit') ?></button>
            </div>
            <div class="container photos">
                <div class="row">
                    <div class="col-3 col-sm-2 photo" v-for="file in uploadedFiles" :key="file['idx']">
                        <div clas="position-relative">
                            <img class="w-100" :src="file['url']">
                            <div class="position-absolute top left font-weight-bold" @click="onFileDelete(file['idx'])">[X]</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php includeVueOnce(); ?>
<script>
    const postEditDefault = Vue.createApp({
        data() {
            return {
                percent: 0,
                files: '<?= $post->v('files') ?>',
                uploadedFiles: <?= json_encode($post->files(), true) ?>,
            }
        },
        created() {
            console.log('created() for post-edit-default');
        },
        methods: {
            onFileChange(event) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }
                const file = event.target.files[0];
                fileUpload(
                    file, {
                        sessionId: '<?= login()->sessionId ?>',
                    },
                    function(res) {
                        console.log("success: res.path: ", res, res.path);
                        postEditDefault.files = addByComma(postEditDefault.files, res.idx);
                        postEditDefault.uploadedFiles.push(res);
                    },
                    alert,
                    function(p) {
                        console.log("pregoress: ", p);
                        this.percent = p;
                    }
                );
            },
            onFileDelete(idx) {
                const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
                if (re === false) return;
                axios.post('/index.php', {
                        sessionId: '<?= login()->sessionId ?>',
                        route: 'file.delete',
                        idx: idx,
                    })
                    .then(function(res) {
                        checkCallback(res, function(res) {
                            console.log('delete success: ', res);
                            postEditDefault.uploadedFiles = postEditDefault.uploadedFiles.filter(function(v, i, ar) {
                                return v.idx !== res.idx;
                            });
                            postEditDefault.files = deleteByComma(postEditDefault.files, res.idx);
                        }, alert);
                    })
                    .catch(alert);
            }
        }
    }).mount("#post-edit-default");
</script>