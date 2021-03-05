<?php
/**
 * @name Default Post List Style
 */


?>

<script>
    function onFileChange(event, id) {
        console.log(event);
        const file = event.target.files[0];
        fileUpload(
            file,
            {
                sessionId: '<?=my(SESSION_ID)?>',
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
            sessionId: '<?=my(SESSION_ID)?>',
            route: 'file.delete',
            idx: idx,
        })
            .then(function (res) {
                respondCallback(res, function(res) {
                    console.log('delete success: ', res);
                }, alert);
            })
            .catch(alert);
    }
</script>

<div class="p-5">
    <form enctype="multipart/form-data" action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.create.submit">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="files" id="files" value="">
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
            <input name="<?=USERFILE?>" type="file" onchange="onFileChange(event, 'files')" />
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
    <div class="files">
        <?php foreach( $post[FILES] as $file ) { ?>
            <div class="position-relative">
                <img class="w-100" src="<?=$file['url']?>">
                <div class="position-absolute" style="top: 0; color: white; background-color: black;" onclick="onClickFileDelete(<?=$file[IDX]?>);">[ X ]</div>
            </div>
        <?php } ?>
    </div>
    <div>
        <form enctype="multipart/form-data" action="/" method="POST">
            <input type="hidden" name="p" value="forum.comment.create.submit">
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
                        <input type="hidden" name="p" value="forum.comment.create.submit">
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


