<?php
/**
 * @name 코드 별 사진 업로드
 */

$post = post(in(IDX, 0));

if ( in(CATEGORY_ID) ) {
    $category = category( in(CATEGORY_ID) );
} else if (in(IDX)) {
    $category = category( $post->v(CATEGORY_IDX) );
} else {
    jsBack('잘못된 접속입니다.');
}
?>
<style>
    .size-80 { width: 80px; height: 80px; }
</style>
<div id="itsuda-event-edit" class="p-5">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?=CATEGORY_ID?>" value="<?=$category->v(ID)?>">
        <input type="hidden" name="<?=IDX?>" value="<?=$post->idx?>">
        <input type="hidden" name="files" v-model="files">

        <div class="form-group">
            <small id="" class="form-text text-muted">이벤트 제목을 적어주세요.</small>
            <label for="">제목</label>
            <div>
                <input class="w-100" type="text" name="title" value="<?=$post->title?>">
            </div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">이벤트 내용을 적어주세요.</small>
            <small class="form-text text-muted">이벤트 날짜, 담청자 목록 등을 적을 수 있습니다.</small>
            <label for="">내용</label>
            <div>
                <textarea class="w-100" rows="10" type="text" name="content"><?=$post->content?></textarea>
            </div>
        </div>
        <hr>
        <?php
        $ini = @parse_ini_string($category->postEditWidgetOption, true, INI_SCANNER_RAW);
        if ( isset($ini['upload-by-code'] ) ) {
            foreach( $ini['upload-by-code'] as $k => $arr) {
                ?>
            <upload-by-code post-idx="<?=$post->idx?>" code="<?=$k?>" label="<?=$arr['label']?>" tip="<?=$arr['tip']?>"></upload-by-code>
        <?php
            }
        }
        ?>
        <hr>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<script>
    mixins.push({
        data: {
            files: '<?=$post->v('files')?>',
        },
    });
</script>

