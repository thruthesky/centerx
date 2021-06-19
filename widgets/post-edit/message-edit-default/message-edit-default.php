<?php
/**
 * @name 쪽지 - 글 작성
 */

if ( !in(OTHER_USER_IDX) ) {
    jsBack('받는 사람 정보가 없습니다.');
}

?>

@todo 받는 사람 표시. 이 때, inbox outbox 에 ㄸ라ㅏ서 처리해야 한다.

    <section class="p-3" id="post-edit-default" style="background-color: #f7f8f8; border-radius: 10px;">
        <form action="/" method="POST">
            <?= hiddens(
                p: 'forum.post.edit.submit',
                return_url: 'view',
                kvs: [
                        CATEGORY_ID => MESSAGE_CATEGORY,
                        OTHER_USER_IDX => in(OTHER_USER_IDX),
                        'private' => 'Y',
                    ],
            );
            ?>

            <input type="hidden" name="files" v-model="files">

            <div class="page-title">
                쪽지 전송
            </div>

            <input class="mt-3 form-control" placeholder="<?= ln('input_title') ?>" type="text" name="<?= TITLE ?>">

            <textarea class="mt-3 form-control" rows="10" placeholder="<?= ln('input_content') ?>" type="text" name="<?= CONTENT ?>"></textarea>


            <div class="mt-3 d-flex">
                <!-- UPLOAD BUTTON -->
                <div class="position-relative overflow-hidden">
                    <img src="/etc/svg/camera.svg" width="32" class="camera-icon">
                    <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" @change="onFileChange($event)" />
                </div>


                <div class="flex-grow-1 mt-2 mr-4">
                    <progress-bar class="ml-2" :progress="percent"></progress-bar>
                </div>

                <button class="btn btn-warning mr-3" type="button" onclick="history.go(-1)"><?=ln('cancel')?></button>
                <!-- SUBMIT BUTTON -->
                <button class="btn btn-success" type="submit"><?=ln('submit')?></button>
            </div>
            <div class="d-none px-3 row photos" :class="{'d-flex': uploadedFiles}">
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
                files: '',
                percent: 0,
                uploadedFiles: [],
            }
        });
    </script>
<?php js('/etc/js/vue-js-mixins/post-edit-form-file.js', 1) ?>
<?php js('/etc/js/vue-js-components/progress-bar.js', 1) ?>