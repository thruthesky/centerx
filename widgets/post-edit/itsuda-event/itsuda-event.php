<?php
/**
 * @name 있수다! 이벤트 편집
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
            <label for="">내용</label>
            <div>
                <textarea class="w-100" rows="10" type="text" name="content" value="<?=$post->content?>"></textarea>
            </div>
            <div class="form-text">이벤트 날짜, 담청자 목록 등을 적을 수 있습니다.</div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">배너 사진을 등록해 주세요. 너비 4, 높이 1 비율로 업로드해 주세요.</small>
            <label for="">배너 사진</label>
            <div>
                <input class="ml-3" name="<?=USERFILE?>" type="file" @change="onFileChange($event, 'banner')" />
                <img class="size-80" :src="banner.url" v-if="banner.url">
            </div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">내용 사진을 업로드 해 주세요.</small>
            <label for="">내용 사진</label>
            <div>
                <input class="ml-3" name="<?=USERFILE?>" type="file" @change="onFileChange($event, 'content')" />
                <img class="size-80" :src="content.url" v-if="content.url">
            </div>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>


<?php
if ( $post->idx ) {
    $banner = files()->findOne(['entity' => $post->idx, 'code' => 'banner']);
    $content = files()->findOne(['entity' => $post->idx, 'code' => 'content']);

    $banner = json_encode($banner->hasError ? [] : $banner->response());
    $content = json_encode($content->hasError ? [] : $content->response());
} else {
    $banner = "[]";
    $content = "[]";
    $web = "[]";
}
?>
<script>
    mixins.push({
        data: {
                percent: 0,
                files: '<?=$post->v('files')?>',
                banner: <?=$banner?>,
                content: <?=$content?>,
                uploadedFiles: <?=json_encode($post->files(), true)?>,
        },
        created: function () {
            console.log('created() for post-edit-default');
        },
        methods: {
            onFileChange(event, code) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }

                // 이전에 업로드된 사진이 있는가?
                if ( itsudaEventEdit[code].idx ) {
                    // 그렇다면, 이전 업로드된 파일이 쓰레기로 남지 않도록 삭제한다.
                    console.log('going to deelte');
                    axios.post('/index.php', {
                        sessionId: '<?=login()->sessionId?>',
                        route: 'file.delete',
                        idx: itsudaEventEdit[code].idx,
                    })
                        .then(function (res) {
                            checkCallback(res, function(res) {
                                console.log('delete success: ', res);
                                itsudaEventEdit.files = deleteByComma(itsudaEventEdit.files, res.idx);
                            }, alert);
                        })
                        .catch(alert);
                }

                //
                const file = event.target.files[0];
                fileUpload(
                    file,
                    {
                        sessionId: '<?=login()->sessionId?>',
                        code: code,
                        deletePreviousUpload: true,
                    },
                    function (res) {
                        console.log("success: res.path: ", res, res.path);
                        itsudaEventEdit.files = addByComma(itsudaEventEdit.files, res.idx);
                        itsudaEventEdit.uploadedFiles.push(res);
                        itsudaEventEdit[code] = res;
                    },
                    alert,
                    function (p) {
                        console.log("progress: ", p);
                        this.percent = p;
                    }
                );
            },
        }
    });
</script>

