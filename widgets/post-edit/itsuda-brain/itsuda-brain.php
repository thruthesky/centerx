<?php
/**
 * @name 예제 - 게시글에 여러 사진과 옵션 표시 - (과거 있수다 두뇌 기능)
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
<div id="itsuda-brain-edit-default" class="p-5">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?=CATEGORY_ID?>" value="<?=$category->v(ID)?>">
        <input type="hidden" name="<?=IDX?>" value="<?=$post->idx?>">
        <input type="hidden" name="files" v-model="files">

        <div class="form-group">
            <small id="" class="form-text text-muted">앱 이름을 적어주세요.</small>
            <label for="">앱 이름</label>
            <div>
                <input type="text" name="title" value="<?=$post->title?>">
            </div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">안드로이드 앱 링크와 앱 아이콘을 업로드 해 주세요.</small>
            <label for="">안드로이드 앱 링크와 앱 아이콘 업로드</label>
            <div>
                <input type="text" name="android" value="<?=$post->v('android')?>">
                <input class="ml-3" name="<?=USERFILE?>" type="file" @change="onFileChange($event, 'android')" />
                <img class="size-80" :src="android.url" v-if="android.url">
            </div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">iOS 앱 링크와 앱 아이콘을 업로드 해 주세요.</small>
            <label for="">iOS 앱 링크와 앱 아이콘 업로드</label>
            <div>
                <input type="text" name="ios" value="<?=$post->v('ios')?>">
                <input class="ml-3" name="<?=USERFILE?>" type="file" @change="onFileChange($event, 'ios')" />
                <img class="size-80" :src="ios.url" v-if="ios.url">
            </div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">웹 링크와 아이콘을 업로드 해 주세요.</small>
            <label for="">웹 링크와 앱 아이콘 업로드</label>
            <div>
                <input type="text" name="web" value="<?=$post->v('web')?>">
                <input class="ml-3" name="<?=USERFILE?>" type="file" @change="onFileChange($event, 'web')" />
                <img class="size-80" :src="web.url" v-if="web.url">
            </div>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<ul>
    <li>
        웹 또는 앱 정보를 업로드해야합니다.
        <ul>
            예)
            <li>웹 (링크와 아이콘)만 업로드해도 됩니다. 웹만 업로드하면, Android 와 iOS 에서 아이콘을 클릭하면 웹이 열립니다.</li>
            <li>또는 안드로이드만 업로드해도 됩니다. 아이콘을 클릭하면 안드로이드에서는 안드로이드 앱이 열립니다. iOS 에는 아이콘이 나타나지 않습니다.</li>
            <li>또는 iOS만 업로드해도 됩니다. 아이콘을 클릭하면, iOS 에서 iOS 앱이 열립니다. Android 에는 나타나지 않습니다.</li>
            <li>웹과 앱 모두 입력하는 경우, 웹만 나타납니다.</li>
        </ul>
    </li>
</ul>


<?php
if ( $post->idx ) {
    $android = files()->findOne(['entity' => $post->idx, 'code' => 'android']);
    $ios = files()->findOne(['entity' => $post->idx, 'code' => 'ios']);
    $web = files()->findOne(['entity' => $post->idx, 'code' => 'web']);

    $android = json_encode($android->hasError ? [] : $android->response());
    $ios = json_encode($ios->hasError ? [] : $ios->response());
    $web = json_encode($web->hasError ? [] : $web->response());
} else {
    $android = "[]";
    $ios = "[]";
    $web = "[]";
}
?>
<script>
    mixins.push({
        data: {
                percent: 0,
                files: '<?=$post->v('files')?>',
                android: <?=$android?>,
                ios: <?=$ios?>,
                web: <?=$web?>,
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
                if ( itsudaBrainEdit[code].idx ) {
                    // 그렇다면, 이전 업로드된 파일이 쓰레기로 남지 않도록 삭제한다.
                    console.log('going to deelte');
                    axios.post('/index.php', {
                        sessionId: '<?=login()->sessionId?>',
                        route: 'file.delete',
                        idx: itsudaBrainEdit[code].idx,
                    })
                        .then(function (res) {
                            checkCallback(res, function(res) {
                                console.log('delete success: ', res);
                                itsudaBrainEdit.files = deleteByComma(itsudaBrainEdit.files, res.idx);
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
                        itsudaBrainEdit.files = addByComma(itsudaBrainEdit.files, res.idx);
                        itsudaBrainEdit.uploadedFiles.push(res);
                        itsudaBrainEdit[code] = res;
                    },
                    alert,
                    function (p) {
                        console.log("pregoress: ", p);
                        this.percent = p;
                    }
                );
            },
        }
    });
</script>

