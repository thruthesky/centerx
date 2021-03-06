<?php
if ( modeCreate() ) {
    d(in());
    $re = translation()->createCode(in());
    if ( isError($re) ) jsBack($re);
}
else if ( modeUpdate() ) {
    $re = translation()->updateCode(in());
    if ( isError($re) ) jsBack($re);
} else if ( modeDelete() ) {
    translation()->deleteCode(in('code'));
}
?>
<div class="container">
    <div class="row">
        <div class="col-3">
            <h3>언어화</h3>
            <hr>
            현재 지원하는 언어: <?=implode(', ', SUPPORTED_LANGUAGES)?>
            <hr>
            지원하는 언어 추가는 config.php 에서 설정하세요.

        </div>
        <div class="col-9">
            <form>
                <input type="hidden" name="p" value="admin.index">
                <input type="hidden" name="w" value="<?=in('w')?>">
                <input type="hidden" name="mode" value="create">


                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control mb-2" name='code' value="" placeholder="언어 코드">
                    </div>
                    <?php foreach( SUPPORTED_LANGUAGES as $ln ) { ?>
                        <div class="col">
                            <input type="text" class="form-control mb-2" name='<?=$ln?>' value="" placeholder="<?=$ln?>">
                        </div>
                    <?php } ?>
                    <div class="col">
                        <button type="submit" class="btn btn-primary mb-2">Create</button>
                    </div>
                </div>

            </form>


            <?php
            foreach( translation()->load() as $code => $texts ) {
                ?>
                <form>
                    <input type="hidden" name="p" value="admin.index">
                    <input type="hidden" name="w" value="<?=in('w')?>">
                    <input type="hidden" name="mode" value="update">
                    <input type="hidden" name="currentCodeName" value="<?=$code?>">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control mb-2" name='code' value="<?=$code?>" placeholder="언어 코드">
                        </div>
                        <?php foreach( SUPPORTED_LANGUAGES as $ln ) { ?>
                            <div class="col">
                                <input type="text" class="form-control mb-2" name='<?=$ln?>' value="<?=$texts[$ln]?>" placeholder="<?=$ln?>">
                            </div>
                        <?php } ?>
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <button type="submit" class="btn btn-sm btn-secondary" name="mode" value="delete" onclick="return confirm('정말 삭제하시겠습니까?');">Delete</button>
                        </div>
                    </div>
                </form>
                <?php
            }
            ?>


        </div>
    </div>
</div>