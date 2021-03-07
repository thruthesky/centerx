<?php
/**
 * @name Default Post View
 */

$post = post()->getFromPath();

?>



<div class="title">
    <h1><?=$post[TITLE]?></h1>
</div>
<div class="meta">
    No. <?=$post[IDX]?>
    User. <?=user($post[USER_IDX])->v(NAME)?>
</div>
<div class="content box mt-3">
    <?=$post[CONTENT]?>
</div>
<section class="buttons mt-3">
    <a class="btn btn-sm btn-secondary" href="/?p=forum.post.edit&idx=<?=$post[IDX]?>">Edit</a>
</section>

<div class="files mt-3">
    <?php foreach( $post[FILES] as $file ) { ?>
        <img class="w-100" src="<?=$file['url']?>">
    <?php } ?>
</div>

<div class="mt-3">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.comment.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post[IDX]?>">
        <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$post[IDX]?>">
        <input type="hidden" name="files" id="files<?=$post[IDX]?>" value="">
        <input type="text" name="<?=CONTENT?>">
        <div>
            <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event, 'files<?=$post[IDX]?>')" />
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

<div class="comments">
    <?php foreach( $post[COMMENTS] as $comment ) {  ?>
        <div class="mb-2 p-3 text-white bg-secondary" style="margin-left: <?=$comment[DEPTH] * 16?>px;">
            No.: <?=$comment[IDX]?>
            <div>
                <?=$comment[CONTENT]?>
            </div>
            <div class="files">
                <?php foreach( $comment[FILES] as $file ) { ?>
                    <img class="w-100" src="<?=$file['url']?>">
                <?php } ?>
            </div>
            <div>
                <form action="/" method="POST">
                    <input type="hidden" name="p" value="forum.comment.edit.submit">
                    <input type="hidden" name="returnTo" value="post">
                    <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post[IDX]?>">
                    <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$comment[IDX]?>">
                    <input type="hidden" name="files" id="files<?=$comment[IDX]?>" value="">
                    <input type="text" name="<?=CONTENT?>" value="">
                    <div>
                        <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event, 'files<?=$comment[IDX]?>')" />
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>
