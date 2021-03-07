<?php
/**
 * @name Default Post List Style
 */


$categoryId = in(CATEGORY_ID);

?>

<a class="btn btn-primary" href="/?p=forum.post.edit&categoryId=<?=in(CATEGORY_ID)?>">Create</a>

<?php
    $posts = post()->search(where: "parentIdx=0 AND categoryId=<$categoryId>");
?>

<?php foreach( $posts as $post ) {
    ?>
    <h1>No. <?=$post[IDX]?> <?=$post[TITLE]?></h1>
    <div class="content">
        <?=$post[CONTENT]?>
    </div>
    <section class="buttons">
        <a class="btn btn-sm btn-secondary" href="/?p=forum.post.edit&idx=<?=$post[IDX]?>">Edit</a>
    </section>
    <div class="files">
        <?php foreach( $post[FILES] as $file ) { ?>
            <img class="w-100" src="<?=$file['url']?>">
        <?php } ?>
    </div>
    <div>
        <form enctype="multipart/form-data" action="/" method="POST">
            <input type="hidden" name="p" value="forum.comment.edit.submit">
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
                    <form action="/">
                        <input type="hidden" name="p" value="forum.comment.edit.submit">
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
<?php } ?>


