<?php



?>

<script>
    function onFileChange(event) {
        console.log(event);
        const file = event.target.files[0];


        fileUpload(
            file,
            '<?=my(SESSION_ID)?>',
            function (res) {
                console.log("success: res.url: ", res, res.url);
            },
            alert,
            function (p) {
                console.log("pregoress: ", p);
            }
        );

    }
</script>

<div class="p-5">
    <form enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.create.submit">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <div>
            categoryId:
            <input type="text" name="<?=CATEGORY_ID?>" value="<?=in(CATEGORY_ID)?>">
        </div>
        <div>
            title:
            <input type="text" name="<?=TITLE?>" value="<?=in(TITLE)?>">
        </div>
        <div>
            content:
            <input type="text" name="<?=CONTENT?>" value="<?=in(CONTENT)?>">
        </div>
        <div>
            <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event)" />
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>


<?php
    $posts = post()->search(where: 'parentIdx=0');
?>

<?php foreach( $posts as $post ) {
    ?>
    <h1>No. <?=$post[IDX]?> <?=$post[TITLE]?></h1>
    <div class="content">
        <?=$post[CONTENT]?>
    </div>
    <div>
        <form enctype="multipart/form-data" action="/" method="POST">
            <input type="hidden" name="p" value="forum.comment.create.submit">
            <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
            <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post[IDX]?>">
            <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$post[IDX]?>">
            <input type="text" name="<?=CONTENT?>">
            <div>
                <input name="<?=USERFILE?>" type="file" />
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
                <div>
                    <form action="/">
                        <input type="hidden" name="p" value="forum.comment.create.submit">
                        <input type="hidden" name="<?=ROOT_IDX?>" value="<?=$post[IDX]?>">
                        <input type="hidden" name="<?=PARENT_IDX?>" value="<?=$comment[IDX]?>">
                        <input type="text" name="<?=CONTENT?>" value="">
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
