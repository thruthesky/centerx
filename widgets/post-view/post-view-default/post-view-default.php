<?php
/**
 * @name Default Post View
 */


$post = post()->current();


?>



<div class="title">
    <h1><?=$post->title?></h1>
</div>
<div class="meta">
    No. <?=$post->idx?>
    User. <?=$post->user()->name?>
    Date: <?=date('r', $post->createdAt)?>
</div>
<div class="content box mt-3">
    <?=$post->content?>
</div>
<section class="buttons mt-3">
    <a class="btn btn-sm btn-secondary" href="/?p=forum.post.edit&idx=<?=$post->idx?>">Edit</a>
    <a class="btn btn-sm btn-secondary" href="/?p=forum.post.delete.submit&idx=<?=$post->idx?>">Delete</a>
    <a class="btn btn-sm btn-secondary" href="/?p=forum.post.list&categoryId=<?=$post->categoryId()?>">List</a>
</section>


<div class="files mt-3">
    <?php foreach( $post->files() as $file ) { ?>
        <img class="w-100" src="<?=$file->url?>">
    <?php } ?>
</div>

<div class="mt-3">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.comment.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post->idx?>">
        <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$post->idx?>">
        <input type="hidden" name="files" id="files<?=$post->idx?>" value="">
        <input type="text" name="<?=CONTENT?>">
        <div>
            <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event, 'files<?=$post->idx?>')" />
        </div>
        <button type="submit">Submit</button>
    </form>
</div>


<div class="comments">
    <?php foreach( $post->comments() as $comment ) {  ?>
        <div class="mb-2 p-3 text-white bg-secondary" style="margin-left: <?=$comment->depth * 16?>px;">
            No.: <?=$comment->idx?>
            <div>
                <?=$comment->content?>
            </div>
            <div class="files">
                <?php foreach( $comment->files() as $file ) { ?>
                    <img class="w-100" src="<?=$file->url?>">
                <?php } ?>
            </div>
            <div>
                <form action="/" method="POST">
                    <input type="hidden" name="p" value="forum.comment.edit.submit">
                    <input type="hidden" name="returnTo" value="post">
                    <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post->idx?>">
                    <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$comment->idx?>">
                    <input type="hidden" name="files" id="files<?=$comment->idx?>" value="">
                    <input type="text" name="<?=CONTENT?>" value="">
                    <div>
                        <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event, 'files<?=$comment->idx?>')" />
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>
