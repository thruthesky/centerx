<?php
/**
 * @name Default Post Edit
 */

?>

<div id="app" class="p-5">
    <form enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="text" name="files" v-model="files">
        <div>
            categoryId:
            <input type="text" name="<?=CATEGORY_ID?>" value="<?=in(CATEGORY_ID)?>">
        </div>
        <div>
            title:
            <input type="text" name="<?=TITLE?>" value="<?=in(TITLE)?>">
        </div>
        <div>
            content:
            <input type="text" name="<?=CONTENT?>" value="<?=in(CONTENT)?>">
        </div>
        <div>
            <input name="<?=USERFILE?>" type="file" @change="onFileChange($event)" />
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<script src="<?=ROOT_URL?>/etc/js/vue.3.0.7.global.prod.min.js"></script>
<script>
    const app = Vue.createApp({
        data() {
            return {
                percent: 0,
                files: '',
                uploadedFiles: [],
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
                        sessionId: '<?=my(SESSION_ID)?>',
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
        }
    }).mount("#app");
</script>

<script>
    function onFileDelete(idx) {
        const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
        if ( re === false ) return;
        axios.post('/index.php', {
            sessionId: '<?=my(SESSION_ID)?>',
            route: 'file.delete',
            idx: idx,
        })
            .then(function (res) {
                respondCallback(res, function(res) {
                    console.log('delete success: ', res);
                }, alert);
            })
            .catch(alert);
    }
</script>
