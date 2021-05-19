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
    <section class="p-3" id="post-edit-default" style="background-color: #f7f8f8; border-radius: 10px;">
        <form action="/" method="POST">
            <?php
                $hidden_data = [
                    IDX => $post->idx,
                    CATEGORY_ID => $category->id,
                    'nsub' => in('subcategory'),
                ];
                echo hiddens(
                    p: 'forum.post.edit.submit',
                    return_url: 'post',
                    kvs: $hidden_data,
                );
                hook()->run('post-edit-form-hidden-tags', $hidden_data);
            ?>

            <input type="hidden" name="files" v-model="files">

            <div class="category d-flex">
                <?=hook()->run('post-edit-title') ?? "<h6>Category: {$category->id}</h6>"?>
                <span class="flex-grow-1"></span>
                <?php if ($category->exists && $category->subcategories) { ?>
                    <select class="form-select form-select-lg mt-2" name="subcategory">
                        <option value=""><?= ek('Select Sub category', '카테고리 선택') ?></option>
                        <?php foreach ($category->subcategories as $cat) {
                            if ($post->subcategory == $cat) $selected =  'selected';
                            else if ($cat == in('subcategory')) $selected = ' selected';
                            else $selected = '';
                            ?>
                            <option value="<?= $cat ?>" <?= $selected ?>><?= $cat ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </div>

            <?=hook()->run('post-edit-form-before-title', $hidden_data)?>
            <input class="mt-3 form-control" placeholder="<?= ln('input_title') ?>" type="text" name="<?= TITLE ?>" value="<?= $post->v(TITLE) ?>">

            <textarea class="mt-3 form-control" rows="10" placeholder="<?= ln('input_content') ?>" type="text" name="<?= CONTENT ?>"><?= $post->v(CONTENT) ?></textarea>
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

                <button class="btn btn-warning mr-3" type="button" onclick="history.go(-1)"><?= ek('Cancel', '취소') ?></button>
                <!-- SUBMIT BUTTON -->
                <button class="btn btn-success" type="submit"><?= ek('Submit', '전송') ?></button>
            </div>
            <div class="px-3 row photos">
                <div class="mt-3 col-4 p-1 photo" v-for="file in uploadedFiles" :key="file['idx']">
                    <div clas="position-relative" style="max-height: 250px">
                        <img class="h-100 w-100" :src="file['url']" style="border-radius: 10px;">
                        <div class="p-2 position-absolute  top left font-weight-bold" @click="onFileDelete(file['idx'])" style="color: red">[X]</div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        mixins.push({
            data: {
                files: '<?= $post->v('files') ?>',
                percent: 0,
                uploadedFiles: <?= json_encode($post->files(true), true) ?>,
            }
        });
    </script>
<?php js('/etc/js/vue-js-mixins/post-edit-form-file.js', 1) ?>