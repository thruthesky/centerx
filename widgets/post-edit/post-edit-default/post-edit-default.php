<?php
/**
 * @name Default Post Edit
 */


$post = post(in(IDX, 0));


if ( in(CATEGORY_ID) ) {
    $category = category( in(CATEGORY_ID) );
} else if (in(IDX)) {
    $category = category( $post->v(CATEGORY_IDX) );
} else {
    jsBack('잘못된 접속입니다.');
}

?>

<div id="app" class="p-5">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="files" v-model="files">
        <input type="hidden" name="<?=CATEGORY_ID?>" value="<?=$category->v(ID)?>">
        <input type="hidden" name="<?=IDX?>" value="<?=$post->idx?>">

        <div>
            title:
            <input type="text" name="<?=TITLE?>" value="<?=$post->v(TITLE)?>">
        </div>
        <div>
            content:
            <input type="text" name="<?=CONTENT?>" value="<?=$post->v(CONTENT)?>">
        </div>
        <div>
            <input name="<?=USERFILE?>" type="file" @change="onFileChange($event)" />
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
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<?php includeVueOnce(); ?>
<script>
    const app = Vue.createApp({
        data() {
            return {
                percent: 0,
                files: '<?=$post->v('files')?>',
                uploadedFiles: <?=json_encode($post->files(), true)?>,
            }
        },
        methods: {
            onFileChange(event) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }
                const file = event.target.files[0];
                fileUpload(
                    file,
                    {
                        sessionId: '<?=login()->sessionId?>',
                    },
                    function (res) {
                        console.log("success: res.path: ", res, res.path);
                        app.files = addByComma(app.files, res.idx);
                        app.uploadedFiles.push(res);
                    },
                    alert,
                    function (p) {
                        console.log("pregoress: ", p);
                        this.percent = p;
                    }
                );
            },
            onFileDelete(idx) {
                const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
                if ( re === false ) return;
                axios.post('/index.php', {
                    sessionId: '<?=login()->sessionId?>',
                    route: 'file.delete',
                    idx: idx,
                })
                    .then(function (res) {
                        checkCallback(res, function(res) {
                            console.log('delete success: ', res);
                            app.uploadedFiles = app.uploadedFiles.filter(function(v, i, ar) {
                                return v.idx !== res.idx;
                            });
                            app.files = deleteByComma(app.files, res.idx);
                        }, alert);
                    })
                    .catch(alert);
            }
        }
    }).mount("#app");
</script>

