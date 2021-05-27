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

    <section class="p-3" id="post-edit-default">
        <form action="/" method="POST" <?=hook()->run(HOOK_POST_EDIT_FORM_ATTR)?>>
            <?php
            $hidden_data = [
                IDX => $post->idx,
                CATEGORY_ID => $category->id,
                'nsub' => in('subcategory'),
            ];
            echo hiddens(
                p: 'forum.post.edit.submit',
                return_url: hook()->run(HOOK_POST_EDIT_RETURN_URL) ?? 'view',
                kvs: $hidden_data,
            );
            hook()->run('post-edit-form-hidden-tags', $hidden_data);
            ?>

            <input type="hidden" name="files" v-model="files">

            <div class="category d-flex">
                <?=hook()->run('post-edit-title') ?? "<h6>Category: <span class='text-uppercase'>{$category->id}<?span></h6>"?>
                <span class="flex-grow-1"></span>
                <?php if ($category->exists && $category->subcategories) { ?>
                    <select class="form-select form-select-lg mt-2" name="subcategory">
                        <option value=""><?= ln('select_category') ?></option>
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

            <?php if ( admin() ) { ?>
                <div class="alert alert-secondary d-flex align-items-center mt-3" role="alert">
                    <div class="form-group form-check mb-0">
                        <input type="hidden" name="reminder" id="reminder" value="<?=$post->reminder?>">
                        <input type="checkbox" class="form-check-input" id="set-reminder" :checked="reminder" v-model="reminder" @change="onChangeReminder()">
                        <label class="form-check-label" for="set-reminder">공지사항으로 표시</label>
                    </div>
                    <div class="ml-5" v-if="reminder">
                        표시 순서:
                        <input name="listOrder" value="<?=$post->listOrder?>">
                    </div>
                </div>
            <?php } ?>


            <?php js('/etc/js/vue-js-components/progress-bar.js', 1) ?>
            <div class="mt-3 d-flex">
                <div class="position-relative overflow-hidden">
                    <img src="/etc/svg/camera.svg" width="32" class="camera-icon d-block mr-2">
                    <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" @change="onFileChange($event)" />
                </div>

                <div class="flex-grow-1 mt-2 mr-4">
                    <progress-bar class="ml-2" :progress="percent"></progress-bar>
                </div>

                <div v-if="!loading">
                    <a class="btn btn-warning mr-3" type="button" href="<?=postListUrl($category->id)?>" <?=hook()->run(HOOK_POST_EDIT_CANCEL_BUTTON_ATTR)?>><?=ln('cancel')?></a>
                    <button class="btn btn-success" type="submit"><?=ln('submit')?></button>
                </div>
                <div class="d-none p-2 red" :class="{'d-block': loading }">
                    전송중입니다...
                </div>

            </div>

            <div class="d-none px-3 row photos" :class="{'d-flex': uploadedFiles}">
                <div class="mt-3 col-4 p-1 photo" v-for="file in uploadedFiles" :key="file['idx']">
                    <div clas="position-relative">
                        <img class="w-100" :src="file['url']">
                        <i class="fa fa-trash p-2 position-absolute top-sm left-sm font-weight-bold red bg-white radius-50 pointer" @click="onFileDelete(file['idx'])"></i>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        mixins.push({
            data: {
                loading: false,
                files: '<?= $post->v('files') ?>',
                percent: 0,
                uploadedFiles: <?= json_encode($post->files(true), true) ?>,
                reminder: <?=$post->reminder=='Y' ? 'true': 'false'?>,
            },
            methods: {
                onChangeReminder: function() {
                    const dom = document.getElementById('reminder');
                    dom.value = this.reminder ? 'Y' : 'N';
                }
            }
        });
    </script>
<?php js('/etc/js/vue-js-mixins/post-edit-form-file.js', 1) ?>