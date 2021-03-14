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


?>

<div id="comment-form">
    <form enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.comment.edit.submit">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post->idx?>">
        <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$parent->idx?>">
        <input type="hidden" name="files" id="files<?=$post->idx?>" value="">
        <input type="text" name="<?=CONTENT?>">
        <div>
            <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event, 'files<?=$post->idx?>')" />
        </div>
        <button type="submit">Submit</button>
    </form>
</div>


<?php
if ( defined('COMMENT_EDIT_DEFAULT_JAVASCRIPT') ) return;
define('COMMENT_EDIT_DEFAULT_JAVASCRIPT', true);
?>
<script>
    function onFileChange(event, id) {
        console.log(event);
        const file = event.target.files[0];
        fileUpload(
            file,
            {
                sessionId: '<?=login()->sessionId?>',
            },
            function (res) {
                console.log("success: res.path: ", res, res.path);
                const $files = document.getElementById(id);
                $files.value = addByComma($files.value, res.idx);
            },
            alert,
            function (p) {
                console.log("pregoress: ", p);
            }
        );
    }
    function onClickFileDelete(idx) {
        const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
        if ( re === false ) return;
        axios.post('/index.php', {
            sessionId: '<?=login()->sessionId?>',
            route: 'file.delete',
            idx: idx,
        })
            .then(function (res) {
                checkCallback(res, function(res) {
                    console.log('delete success: ', res);
                }, alert);
            })
            .catch(alert);
    }
</script>
