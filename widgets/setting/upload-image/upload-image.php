<h2><?=$admin_upload_title??''?></h2>
<?php if ( isset($admin_upload_description) ) { ?>
    <div class="bg-white border-radius-md mb-3 p-3"><?=$admin_upload_description?></div>
<?php } ?>
코드: <span class="em"><?=in('code')?></span>

<hr>
<?php
$file = files()->getByCode(in('code'));
?>
<section id="admin-upload-image">
    <form>
        <div class="position-relative overflow-hidden">
            <button class="btn btn-primary" type="submit">사진 업로드</button>
            <input class="position-absolute left top fs-lg opacity-0" type="file" @change="onFileChange($event)">
        </div>
    </form>
    <div v-if="percent">업로드 퍼센티지: {{ percent }} %</div>
    <hr>
    <div class="" v-if="src">
        <img class="w-100" :src="src">
    </div>
</section>

<hr>

<div class="hint">
    <div>사진 업로드 위젯: 해당 코드로 이미지를 업로드하고, 이미지 idx 를 관리자 설정에 저장합니다. 만약, 새로운 이미지를 올리면 기존의 사진은 삭제됩니다.</div>
    <div>입력값: 제목 $admin_upload_title, 내용: $admin_upload_description, 코드: in('code')</div>
</div>

<script>
    mixins.push({
        data: {
                percent: 0,
                src: "<?=$file->url?>"
        },
        mounted: function () { console.log("admin-upload-image 마운트 완료!"); },
        methods: {
            onFileChange: function(event) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }
                const file = event.target.files[0];
                const self = this;
                fileUpload( // 파일 업로드 함수로 파일 업로드
                    file,
                    {
                        sessionId: '<?=login()->sessionId?>',
                        code: '<?=in('code')?>',
                        deletePreviousUpload: 'Y'
                    },
                    function (res) {
                        console.log("파일 업로드 성공: res.path: ", res, res.path);
                        self.src = res.url;
                        self.percent = 0;
                        axios({ // 파일 업로드 후, file.idx 를 관리자 설정에 추가.
                            method: 'post',
                            url: '/index.php',
                            data: {
                                route: 'app.setConfig',
                                code: '<?=in('code')?>',
                                data: res.idx
                            }
                        })
                            .then(function(res) { console.log('app.setConfig success:', res); })
                            .catch(function(e) { conslole.log('app.setConfig error: ', e); })
                    },
                    alert, // 에러가 있으면 화면에 출력.
                    function (p) { // 업로드 프로그레스바 표시 함수.
                        console.log("업로드 퍼센티지: ", p);
                        self.percent = p;
                    }
                );
            },
        }
    });
</script>