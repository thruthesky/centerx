<?php
/**
 * @name 쪽지 - 글 작성
 */

if ( !in(OTHER_USER_IDX) ) {
    jsBack('받는 사람 정보가 없습니다.');
}

?>
    <section class="p-3" id="post-edit-default" style="background-color: #f7f8f8; border-radius: 10px;">
        <form action="/" method="POST">
            <?= hiddens(
                p: 'forum.post.edit.submit',
                return_url: 'post',
                kvs: [CATEGORY_ID => MESSAGE_CATEGORY],
            );
            ?>

            <input type="hidden" name="files" v-model="files">

            <div class="page-title">
                쪽지 전송
            </div>

            <input class="mt-3 form-control" placeholder="<?= ln('input_title') ?>" type="text" name="<?= TITLE ?>">

            <textarea class="mt-3 form-control" rows="10" placeholder="<?= ln('input_content') ?>" type="text" name="<?= CONTENT ?>"></textarea>

            <progress-bar progress="28"></progress-bar>

            <div class="mt-3 d-flex">
                <!-- UPLOAD BUTTON -->
                <div class="position-relative overflow-hidden">
                    <img src="/etc/svg/camera.svg" width="32" class="camera-icon">
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
<style>
    .camera-icon {
        filter: invert(0.34);
    }
    .camera-icon:hover {
        filter: invert(0);
    }
</style>
    <script>
        mixins.push({
            data: {
                files: '',
                percent: 0,
                uploadedFiles: [],
            }
        });
    </script>
<?php js('/etc/js/vue-js-mixins/post-edit-form-file.js', 1) ?>
<?php js('/etc/js/vue-js-components/progress-bar.js', 1) ?>