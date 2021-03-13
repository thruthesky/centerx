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
$comment = $o['comment'];


?>

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

