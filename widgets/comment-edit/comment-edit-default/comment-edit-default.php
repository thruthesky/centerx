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
?>

<div id="comment-edit-default-form">
    <form enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.comment.edit.submit">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?= ROOT_IDX ?>" value="<?= $post->idx ?>">
        <input type="hidden" name="<?= PARENT_IDX ?>" value="<?= $parent->idx ?>">
        <input type="hidden" name="files" id="files<?= $parent->idx ?>" value="">

        <div class="d-flex">
            <div style="width: 100px;" class="position-relative overflow-hidden">
                <!-- TODO: camera icon -->
                <button class="btn btn-primary w-100" type="button">Upload</button>
                <input class="position-absolute top left h-100 opacity-0" name="<?= USERFILE ?>" type="file" onchange="onFileChange(event, 'files<?= $parent->idx ?>')" />
            </div>
            <textarea style="height: 40px; min-height: 40px; max-height: 150px;" class="form-control mx-2" type="text" name="<?= CONTENT ?>"></textarea>
            <button class="btn btn-primary" type="submit"><?= ek('Submit', '@T Submit') ?></button>
        </div>
    </form>
</div>


<?php
if (defined('COMMENT_EDIT_DEFAULT_JAVASCRIPT')) return;
define('COMMENT_EDIT_DEFAULT_JAVASCRIPT', true);
?>

<?php includeVueOnce(); ?>
<script>
    const postListCreateView = Vue.createApp({
        created() {
            console.log("created() for : comment-edit-default-form")
        }
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
                console.log("success: res.path: ", res, res.path);
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
                }, alert);
            })
            .catch(alert);
    }
</script>