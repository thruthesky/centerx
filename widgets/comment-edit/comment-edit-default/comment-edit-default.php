<?php

$o = getWidgetOptions();

/**
 * @var Post $post
 */
$post =  $o['post'];

/**
 * @var Comment|Post $parent
 */
$parent = $o['parent'];

/**
 * @var Comment $comment 수정 할 때만 필요. 즉, 이 값이 있으면 수정.
 */
$comment = $o['comment'] ?? null;

/// when edit, $parent->idx must be changed to $comemnt->idx.

/**
 * @var File[]
 */
$uploadedFiles = [];
$fileUploadIdx;
$filesString = '';
if ($comment) {
    $fileUploadIdx = $comment->idx;
    $uploadedFiles = $comment->files();
    $filesString = $comment->v('files');
} else {
    $fileUploadIdx = $parent->idx . 'reply';
}
?>

<div id="comment-edit-default-form">
    <form class="m-0" enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.comment.edit.submit">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?= ROOT_IDX ?>" value="<?= $post->idx ?>">
        <input type="hidden" name="files" id="files<?= $fileUploadIdx ?>" value="<?= $filesString ?>">
        <?php if ($comment) { ?>
            <!-- Update -->
            <input type="hidden" name="<?= IDX ?>" value="<?= $comment->idx ?>">
        <?php } else { ?>
            <!-- Create -->
            <input type="hidden" name="<?= PARENT_IDX ?>" value="<?= $parent->idx ?>">
        <?php } ?>

        <textarea style="height: 40px; max-height: 150px;" class="form-control" name="<?= CONTENT ?>" placeholder="<?= ek('Reply ...', '@T Reply ...') ?>"><?php if ($comment) echo $comment->content ?>
</textarea>

        <div class="d-flex mt-2">
            <div style="width: 100px;" class="position-relative overflow-hidden">
                <!-- TODO: camera icon -->
                <button class="btn btn-sm btn-primary w-100" type="button">Upload</button>
                <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" onchange="onFileChange(event, 'files<?= $fileUploadIdx ?>')" />
            </div>
            <div class="flex-grow-1"></div>
            <?php if ($comment) { ?>
                <button class="btn btn-sm btn-warning mr-2" type="button" onclick="hideCommentEditForm(<?= $comment->idx ?>)"><?= ek('Cancel', '@T Cancel') ?></button>
            <?php } ?>
            <button class="btn btn-sm btn-primary" type="submit"><?= ek('Submit', '@T Submit') ?></button>
        </div>
    </form>

    <?php if (count($uploadedFiles)) { ?>
        <div class="container photos">
            <div class="row">
                <?php foreach ($uploadedFiles as $file) { ?>
                    <div class="col-3 col-sm-2 photo" id="file-<?= $file->idx ?>">
                        <div clas="position-relative">
                            <img class="w-100" src="<?= $file->url ?>">
                            <div class="position-absolute top left font-weight-bold" onclick="onClickFileDelete(<?= $file->idx ?>)">[ X ]</div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>


<?php
if (defined('COMMENT_EDIT_DEFAULT_JAVASCRIPT')) return;
define('COMMENT_EDIT_DEFAULT_JAVASCRIPT', true);
?>

<?php includeVueOnce(); ?>
<script>
    const commentEditDefaultForm = Vue.createApp({
        created() {
            console.log("created() for : comment-edit-default-form")
        },
    }).mount("#comment-edit-default-form");
</script>


<script>
    function onFileChange(event, id) {
        console.log(event);
        const file = event.target.files[0];
        fileUpload(
            file, {
                sessionId: '<?= login()->sessionId ?>',
            },
            function(res) {
                console.log("success: res.path: ", res, res.path, id);
                const $files = document.getElementById(id);
                $files.value = addByComma($files.value, res.idx);
            },
            alert,
            function(p) {
                console.log("pregoress: ", p);
            }
        );
    }

    function onClickFileDelete(idx) {
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
                    document.getElementById('file-' + res.idx).remove();
                    deleteByComma('files<?= $fileUploadIdx ?>', res.idx)
                }, alert);
            })
            .catch(alert);
    }
</script>