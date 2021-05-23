<?php
/**
 * @name 광고 - 수정
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
        <form action="/" method="POST">
            <?=hiddens(
                p: 'forum.post.edit.submit',
                return_url: 'edit',
                kvs: [
                    IDX => $post->idx,
                    CATEGORY_ID => $category->id,
                ],
            ) ?>

            <input type="hidden" name="files" v-model="files">


            <input class="mt-3 form-control" placeholder="<?= ln('input_title') ?>" type="text" name="<?= TITLE ?>" value="<?= $post->v(TITLE) ?>">

            <textarea class="mt-3 form-control" rows="10" placeholder="<?= ln('input_content') ?>" type="text" name="<?= CONTENT ?>"><?= $post->v(CONTENT) ?></textarea>


            <div class="mt-3 d-flex">
                <div v-if="!loading">
                    <a class="btn btn-warning mr-3" type="button" href="<?=postListUrl($category->id)?>" <?=hook()->run(HOOK_POST_EDIT_CANCEL_BUTTON_ATTR)?>><?=ln('cancel')?></a>
                    <button class="btn btn-success" type="submit"><?=ln('submit')?></button>
                </div>
                <div class="d-none p-2 red" :class="{'d-block': loading }">
                    전송중입니다...
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