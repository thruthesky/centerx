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
global $fileUploadIdx;
$filesString = '';
if ($comment) {
    $fileUploadIdx = $comment->idx;
    $uploadedFiles = $comment->files();
    $filesString = $comment->v('files');
} else {
    $fileUploadIdx = $parent->idx . 'reply';
}
?>

<div id="comment-edit-default-form<?= $fileUploadIdx ?>">
    <form class="m-0" enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.comment.edit.submit">
        <input type="hidden" name="<?= ROOT_IDX ?>" value="<?= $post->idx ?>">
        <input type="hidden" name="files" id="files<?= $fileUploadIdx ?>" value="<?= $filesString ?>">
        <?php if ($comment) { ?>
            <!-- Update -->
            <input type="hidden" name="<?= IDX ?>" value="<?= $comment->idx ?>">
        <?php } else { ?>
            <!-- Create -->
            <input type="hidden" name="<?= PARENT_IDX ?>" value="<?= $parent->idx ?>">
        <?php } ?>

        <textarea style="height: 40px; max-height: 150px;" class="form-control" name="<?= CONTENT ?>" placeholder="<?= ln('reply') ?>"><?php if ($comment) echo $comment->content ?>
</textarea>

        <div class="d-flex mt-2">
            <div style="width: 100px;" class="position-relative overflow-hidden">
                <!-- TODO: camera icon -->
                <button class="btn btn-sm btn-primary w-100" type="button">Upload</button>
                <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" onchange="onCommentFormFileChange(event, <?= $fileUploadIdx ?>)" />
            </div>
            <div class="flex-grow-1"></div>
            <?php if ($comment) { ?>
                <button class="btn btn-sm btn-warning mr-2" type="button" onclick="hideCommentEditForm(<?= $comment->idx ?>)"><?= ln('cancel') ?></button>
            <?php } ?>
            <button class="btn btn-sm btn-primary" type="submit"><?= ln('submit') ?></button>
        </div>

        <div class="progress-bar" role="progressbar" :style="{ 'width': percent + '%' }" aria-valuemin="0" aria-valuemax="100"></div>
    </form>

    <?php if (count($uploadedFiles)) { ?>
        <div class="px-3 row photos">
            <?php foreach ($uploadedFiles as $file) { ?>
                <div class="col-4 photo" id="file-<?= $file->idx ?>">
                    <div clas="position-relative" style="height: 250px">
                        <img class="h-100 w-100" src="<?= $file->url ?>" style="border-radius: 10px;">
                        <div class="p-2 position-absolute top left font-weight-bold" onclick="onCommentFormFileDelete(<?= $file->idx ?>)" style="color: red">[ X ]</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>
    function onCommentFormFileChange(event, idx) {
        console.log(event);
        const file = event.target.files[0];
        fileUpload(
            file, {
                sessionId: '<?= login()->sessionId ?>',
            },
            function(res) {
                console.log("success: res.path: ", res, res.path, idx);
                const $files = document.getElementById('files' + idx);
                $files.value = addByComma($files.value, res.idx);
            },
            alert,
            function(p) {
                console.log("@TODO pregoress: ", p);
            }
        );
    }
    function onCommentFormFileDelete(idx) {
        const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
        if (re === false) return;
        axios.post('/index.php', {
            route: 'file.delete',
            idx: idx,
        })
            .then(function(res) {
                checkCallback(res, function(res) {
                    console.log('delete success: ', res);
                    document.getElementById('file-' + res.idx).remove();
                    deleteByComma('files' + idx, res.idx)
                }, alert);
            })
            .catch(alert);
    }
</script>