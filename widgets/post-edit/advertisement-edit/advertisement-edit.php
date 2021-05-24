<?php
/**
 * @name 광고 - 수정
 */

$post = post(in(IDX, 0));

if (in(CATEGORY_ID)) {
    $category = category(in(CATEGORY_ID));
} else if (in(IDX)) {
    $category = category($post->v(CATEGORY_IDX));
} else {
    jsBack('잘못된 접속입니다.');
}
?>

    <section class="p-3" id="post-edit-default">

        <form action="/" method="POST">
            <?=hiddens(
                p: 'forum.post.edit.submit',
                return_url: 'edit',
                kvs: [
                    IDX => $post->idx,
                    CATEGORY_ID => $category->id,
                    'private' => 'Y',
                ],
            ) ?>

            <input type="hidden" name="files" v-model="files">



            <div class="form-group">
                <input class="mt-3 form-control" placeholder="상호명, 담당자, 연락처 등을 적어주세요." type="text" name="<?= PRIVATE_TITLE ?>" value="<?= $post->privateTitle ?>">
                <small class="form-text text-muted">상호명, 담당자, 연락처 등을 적어주세요.</small>
            </div>


            <div class="form-group">
                <textarea class="mt-3 form-control" rows="10" placeholder="광고비 입금 날짜, 금액, 기간 등의 특이사항을 입력해주세요." type="text" name="<?= PRIVATE_CONTENT ?>"><?= $post->privateContent ?></textarea>
                <small class="form-text text-muted">광고비 입금 날짜, 금액, 기간 등의 특이사항을 입력해주세요.</small>
            </div>

            <div class="form-group bg-light p-3">
                <label>광고 시작 날짜와 끝 날짜</label>
                <div>
                    <input type="date" name="beginAt" value="<?=$post->beginAt ? date('Y-m-d', $post->beginAt) : 0?>">
                    <input type="date" name="endAt" value="<?=$post->endAt ? date('Y-m-d', $post->endAt) : 0?>">
                    <span class="ml-2">남은 광고 일 수: <?=daysBetween($post->beginAt, $post->endAt)?></span>
                </div>
                <small class="form-text text-muted">광고비 시작 날짜와 끝 날짜를 선택해주세요.</small>
                <small class="form-text text-muted">참고: 날짜 입력은 직접 입력하지 않고, Input 태그의 달력에서 날짜를 선택한다. type=date 의 표시는 YYYY/MM/DD 이지만, PHP 로 전달은 YYYY-MM-DD 이다.</small>
                <small class="form-text text-muted">참고: 광고가 23일 까지이면, 밤 23일까지 표시된다. 즉, 광고가 0일 남아도, 마지막 날 밤까지 광고가 표시된다.</small>
            </div>



            <div class="form-group bg-light p-3">
                <label>광고 표시 순서</label>
                <input class="form-control" placeholder="광고 표시 순서" type="text" name="listOrder" value="<?= $post->listOrder ?? 0 ?>">
                <small class="form-text text-muted">높은 숫자가 먼저 나타남. 동일한 순서인 경우, 광고 기간이 많이 남은 광고가 먼저 표시.</small>
                <small class="form-text text-muted">주의: 1개의 광고가 여러 위치에 배너가 표시되는 경우, 모든 위치에 이 표시 순서가 적용된다.</small>
                <small class="form-text text-muted">가능한, 목록 순서를 지정하지 않고, 광고가 많이 남은 순서로 표시한다. 단, 최상단 배너의 경우는 필요.</small>

            </div>

            <div class="form-group bg-light p-3">
                <label>최 상단 배너</label>
                <upload-image taxonomy="<?=POSTS?>" entity="<?=$post->idx?>" code="<?=AD_TOP?>"></upload-image>
                <small class="form-text text-muted">
                    너비: 408px. 높이: 160px.
                </small>
                <label>표시 위치</label>
                <input class="form-control" type="text" name="<?=AD_TOP?>" value="<?=$post->v(AD_TOP)?>">
                <small class="form-text text-muted">'L' 을 입력하면 왼쪽, 'R' 을 입력하면 오른쪽.</small>
            </div>

            <div class="form-group bg-light p-3">
                <label>날개 & 모바일 첫 화면 배너</label>
                <upload-image taxonomy="<?=POSTS?>" entity="<?=$post->idx?>" code="<?=AD_WING?>"></upload-image>
                <small class="form-text text-muted">
                    너비: 408px. 높이: 160px.
                </small>
                <label>표시 위치</label>
                <input class="form-control" type="text" name="<?=AD_WING?>" value="<?=$post->v(AD_WING)?>">
                <small class="form-text text-muted">위치를 지정하지 않으면, 데스크톱 전체 페이지 및 모바일 첫 화면에 표시. 위치 지정하면 해당 "게시판.카테고리"에만 표시.</small>
                <small class="form-text text-muted">위치 표시 방법: 점(.)으로 분리하여 "게시판아이디.카테고리"를 입력. 예) qna.비자</small>
                <small class="form-text text-muted">위치에 공백을 입력하면 전체 페이지에 나온다.</small>

            </div>


            <div class="form-group bg-light p-3">
                <label>게시판 목록 사각 배너</label>
                <upload-image taxonomy="<?=POSTS?>" entity="<?=$post->idx?>" code="<?=AD_POST_LIST_SQUARE?>"></upload-image>
                <small class="form-text text-muted">
                    너비: 320px. 높이: 320px.
                </small>
                <label>표시 위치</label>
                <input class="form-control" type="text" name="<?=AD_POST_LIST_SQUARE?>" value="<?=$post->v(AD_POST_LIST_SQUARE)?>">
                <small class="form-text text-muted">점(.)으로 분리하여 "게시판아이디.카테고리"를 입력. 예) qna.비자</small>
            </div>

            <div class="form-group bg-dark p-3">
                <div class="alert alert-secondary">@TODO 아직 프리미엄 배너는 지원하지 않음. 광고주가 많아지면 개발 할 것.</div>
                <label>프리미엄 배너(게시판 목록 썸네일+텍스트 광고)</label>
                <upload-image taxonomy="<?=POSTS?>" entity="<?=$post->idx?>" code="<?=AD_POST_LIST_THUMBNAIL?>"></upload-image>
                <small class="form-text text-muted">
                    너비: 320px. 높이: 320px.
                </small>
                <label>표시 위치</label>
                <input class="form-control" type="text" name="<?=AD_POST_LIST_THUMBNAIL?>" value="<?=$post->v(AD_POST_LIST_THUMBNAIL)?>">
                <small class="form-text text-muted">점(.)으로 분리하여 "게시판아이디.카테고리"를 입력. 예) qna.비자</small>
            </div>


            <div class="mt-3 d-flex justify-content-between">
                <a class="btn btn-danger mr-3" type="button" href="<?=postDeleteUrl($post->idx)?>" onclick="return confirm('<?=ln('confirm_delete')?>')"><?=ln('delete')?></a>
                <div>
                    <a class="btn btn-warning mr-3" type="button" href="<?=postListUrl($category->id)?>"><?=ln('list')?></a>
                    <button class="btn btn-success" type="submit"><?=ln('submit')?></button>
                </div>
            </div>

        </form>

        <small class="form-text text-muted">
            <ul>
                <li>README.md 참고</li>
                <li>배너 사진은 비율을 유지한 채로 파일 용량을 적당히 해서 (실물보다 더 크게) 작성하면 된다. 실제 보일 때에는 작게 보일 수 있다.</li>
            </ul>
        </small>

    </section>

    <style>
        .uploaded-image img {
            max-width: 100%;
        }
        .upload-button {
            margin-top: .5em;
        }
    </style>

    <script>
        mixins.push({
            data: {
                loading: false,
                files: '<?= $post->v('files') ?>',
                percent: 0,
                uploadedFiles: <?= json_encode($post->files(true), true) ?>,
                reminder: <?=$post->reminder=='Y' ? 'true': 'false'?>,
            },
            methods: {
                onChangeReminder: function() {
                    const dom = document.getElementById('reminder');
                    dom.value = this.reminder ? 'Y' : 'N';
                }
            }
        });
    </script>
<?php js('/etc/js/vue-js-mixins/post-edit-form-file.js', 1) ?>
<?php js('/etc/js/vue-js-components/upload-image.js')?>