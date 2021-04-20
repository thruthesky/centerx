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
<section class="p-5" id="post-edit-default" style="background-color: #f0f0f0; border-radius: 10px;">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="files" v-model="files">
        <input type="hidden" name="<?= CATEGORY_ID ?>" value="<?= $category->v(ID) ?>">
        <input type="hidden" name="lsub" value="<?= in('lsub') ?>">
        <input type="hidden" name="<?= IDX ?>" value="<?= $post->idx ?>">

        <div class="d-flex">
            <h3>Category: <?= $category->id ?></h3>
            <span class="flex-grow-1"></span>
            <?php if ($category->exists && $category->subcategories) { ?>
                <select class="form-select form-select-lg mt-2" name="subcategory">
                    <option value=""><?= ek('Select Sub category', '카테고리 선택') ?></option>
                    <?php foreach ($category->subcategories as $cat) {
                        if ($post->subcategory == $cat) $selected =  'selected';
                        else if ($cat == in('lsub')) $selected = ' selected';
                        else $selected = '';
                    ?>
                        <option value="<?= $cat ?>" <?= $selected ?>><?= $cat ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>

        <input class="mt-3 form-control" placeholder="<?= ek('Title', '제목') ?>" type="text" name="<?= TITLE ?>" value="<?= $post->v(TITLE) ?>">

        <textarea class="mt-3 form-control" rows="10" placeholder="<?= ek('Content', '내용') ?>" type="text" name="<?= CONTENT ?>"><?= $post->v(CONTENT) ?></textarea>
        <!-- Buttons. TODO: progress bar -->
        <div class="mt-3 d-flex">
            <!-- UPLOAD BUTTON -->
            <div style="width: 100px" class="position-relative overflow-hidden">
                <!-- TODO: camera icon -->
                <button class="btn btn-primary" type="button">Upload</button>
                <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" @change="onFileChange($event)" />
            </div>

            <div class="flex-grow-1 mt-2 mr-4">
                <div v-if="percent !== 0" class="progress">
                    <div class="progress-bar" role="progressbar" :style="{ 'width': percent + '%' }" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            
            <button class="btn btn-warning mr-3" type="button" @click="window.history.back()"><?= ek('Cancel', '취소') ?></button>
            <!-- SUBMIT BUTTON -->
            <button class="btn btn-success" type="submit"><?= ek('Submit', '전송') ?></button>
        </div>
        <div class="px-3 row photos">
            <div class="mt-3 col-4 p-1 photo" v-for="file in uploadedFiles" :key="file['idx']">
                <div clas="position-relative" style="height: 250px">
                    <img class="h-100 w-100" :src="file['url']" style="border-radius: 10px;">
                    <div class="p-2 position-absolute  top left font-weight-bold" @click="onFileDelete(file['idx'])" style="color: red">[X]</div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    mixins.push({
        data: function() {
            return {
                percent: 0,
                files: '<?= $post->v('files') ?>',
                uploadedFiles: <?= json_encode($post->files(true), true) ?>,
            };
        },
        created: function() {
            console.log('created() for post-edit-default');
        },
        methods: {
            onFileChange(event) {
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
                        self.files = addByComma(self.files, res.idx);
                        self.uploadedFiles.push(res);
                        self.percent = 0;
                    },
                    alert,
                    function(p) {
                        console.log("progress: ", p);
                        self.percent = p;
                    }
                );
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
                    self.files = deleteByComma(self.files, res.idx);
                }, alert);
            }
        }
    });
</script>