<?php
if ( modeDelete() ) {
    $post = post(in(IDX))->markDelete();
    if ( $post->hasError ) {
        bsAlert("삭제 실패: $re");
    } else {
        jsGo("/?p=" . in('p') . "&w=" . in('w'));
    }
} else if ( modeSubmit() ) {
    $in = in();
    $in[CATEGORY_ID] = SHOPPING_MALL;
    if ( $in[IDX] ) {
        $post = post($in[IDX])->update($in);
    } else {
        $post = post()->create($in);
    }
} else if ( in(IDX) ) {
    $post = post(in(IDX));
} else {
    $post = post();
}

$category = category(SHOPPING_MALL);

?>
<style>
    .hint { font-size: .8rem; color: #888888; }
</style>
<section id="app">

    <h1>상품 등록</h1>
    <form method="post" action="/">

        <?=hiddens(in: ['p', 'w', 'cw'], mode: 'submit', kvs: ['idx' => $post->idx])?>


        <div class="form-group mb-3">
            <label for="post_title">카테고리</label>
            <select name="subcategory" class="custom-select">
                <option value="">카테고리 선택</option>
                <?php foreach( $category->subcategories as $subcategory ) { ?>
                    <option value="<?=$subcategory?>" <?php if ( $subcategory == ($post->subcategory ?? '') ) echo "selected"; ?>><?=$subcategory?></option>
                <?php } ?>
            </select>
        </div>


        <div class="form-group mb-3">
            <label for="post_title">제목</label>
            <input type="text" class="form-control" name="title" value="<?=$post->title ?? ''?>">
        </div>


        <div class="form-group mb-3">
            <label for="short_title">짧은 제목</label>
            <input type="text" class="form-control" name="shortTitle" value="<?=$post->shortTitle?>">
            <div class="hint">
                메인 화면이나 위젯에 표시할 짧은 제목. 한글 8글자.
            </div>
        </div>


        <div class="form-group mb-3">
            <label for="short_title">키워드(또는 카피)</label>
            <input type="text" class="form-control" name="keywords" value="<?=$post->keywords?>">
            <div class="hint">
                상품을 설명을 할 때, 보여지는 짧은 키워드 문구. 한 줄로 입력 할 수 있으며, 콤마로 구분하여 입력 가능.
                <div class="d-block hint">예) 여름 신상품 초특가 세일</div>
                <div class="d-block hint">예) 신발,장화</div>
            </div>
        </div>


        <div class="form-group mb-3">
            <label for="price">가격</label>
            <input type="number" class="form-control" id="price" name="price" @keyup="onPriceChange" v-model="post.price">
            <div class="hint">
                할인된 가격: <span>{{ discountedPrice }}</span> 원 (할인율이 적용된 후의 가격입니다.)
            </div>
        </div>





        <div class="form-group mb-3">
            <label for="discountRate">할인율</label>
            <input type="number" class="form-control" id="discountRate" name="discountRate" @keyup="onPriceChange" v-model="post.discountRate">
            <div class="hint">
                단위 %. 가격에서 자동으로 할인율이 계산되어 화면에 표시됩니다.
            </div>
        </div>


        <div class="form-group mb-3">
            <label for="point">적립포인트</label>
            <input type="number" class="form-control" id="point" name="point" v-model="post.point">
            <div class="hint">
                화면 표시 예) 적립 포인트 1,000 Point 지급. 숫자만 입력.
            </div>
        </div>



        <?php /*
        <label for="point">운영 또는 일시 중단</label>
        <div class="form-check">
            <div class="form-check">
                <input class="form-check-input" type="radio" id="pauseY" name="pause" value="Y" <?= $post->pause == 'Y' ? 'checked' : '' ?>>
                <label class="form-check-label" for="pauseY">
                    운영
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="pauseN" name="pause" value="N" <?= $post->pause == 'N' ? 'checked' : '' ?>>
                <label class="form-check-label" for="pauseN">
                    중단
                </label>
            </div>
        </div>
        <div class="hint">본 상품을 사이트(앱)에 노출이 안되도록 일시 중지 할 수 있습니다.</div>
 */?>


        <div class="form-group mb-3">
            <label for="volume">용량, 수량</label>
            <input type="text" class="form-control" id="volume" name="volume" value="<?=$post->volume?>">
            <div class="form-text">
                상품의 크기나, 용량, 수량을 입력하세요.
            </div>
        </div>

        <div class="form-group mb-2">
            <label for="short_title"><a href="https://docs.google.com/document/d/1JnEIoytM1MgS35emOju90qeDoIH963VeMHLaqvOhA7o/edit#heading=h.inp7ewl4tmv3" target="_blank">옵션 [?]</a></label>
            <input type="text" class="form-control" id="options" name="options" value="<?=$post->options?>">
        </div>

        <label class="form-check-label" for="option_item_price">
            옵션에 상품가격지정 <a href="https://docs.google.com/document/d/1JnEIoytM1MgS35emOju90qeDoIH963VeMHLaqvOhA7o/edit#heading=h.t9yy0z10h3rp" target="_blank">[?]</a>
        </label>
        <div class="form-check">
            <div class="form-check">
                <input class="form-check-input" type="radio" id="optionItemPriceN" name="optionItemPrice" value="N" <?= $post->optionItemPrice != 'N' ? 'checked' : '' ?>>
                <label class="form-check-label" for="optionItemPriceN">
                    옵션에 추가금액지정
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="optionItemPriceY" name="optionItemPrice" value="Y" <?= $post->optionItemPrice == 'Y' ? 'checked' : '' ?>>
                <label class="form-check-label" for="optionItemPriceY">
                    옵션에 상품가격지정
                </label>
            </div>

            <div class="hint">
                <a href="https://docs.google.com/document/d/1JnEIoytM1MgS35emOju90qeDoIH963VeMHLaqvOhA7o/edit#heading=h.inp7ewl4tmv3" target="_blank">상품 옵션 설명을 참고 해 주세요. [?]</a>
            </div>

        </div>



<?php /*
        <div class="form-group mb-3">
            <label for="deliveryFee">배송비</label>
            <input type="number" class="form-control" id="deliveryFee" name="deliveryFee" value="<?=$post['deliveryFee']??''?>">
            <div class="form-text">
                배송비를 입력하세요.
            </div>
        </div>
*/ ?>

        <div class="form-group mb-3">
            <label for="storageMethod">보관방법</label>
            <input type="text" class="form-control" id="storageMethod" name="storageMethod" value="<?=$post->storageMethod?>">
            <div class="form-text">
                보관 방법을 입력하세요. 예) 냉장고에 보관하세요.
            </div>
        </div>


        <div class="form-group mb-3">
            <label for="expiry">유통기한</label>
            <input type="text" class="form-control" id="expiry" name="expiry"  value="<?=$post->expiry?>">
            <div class="form-text">
                유통 기한을 입력하세요. 예) 2022년 3월 30일 까지.
            </div>
        </div>


        <div class="mb-3">
            사진은 .gif(애니메이션 가능) 또는 .jpg, .png 으로 업로드 가능하며, 업로드된 사진을 클릭하면, 삭제 할 수 있습니다.
        </div>

        <?php
        $images = [
            ['field' => 'primaryPhoto', 'title' => '대표 사진', 'desc' => '상품 페이지 맨 위에 나오는 사진'],
            ['field' => 'widgetPhoto', 'title' => '위젯 사진', 'desc' => '각종 위젯에 표시'],
            ['field' => 'detailPhoto', 'title' => '설명 사진', 'desc' => '상품을 정보/설명/컨텐츠를 보여주는 사진'],
        ]
        ?>
        <?php foreach( $images as $image ) { ?>

                <input type="hidden" name="<?=$image['field']?>" id="<?=$image['field']?>" value="<?=$post->v($image['field'])?>">
        <div class="mb-3 of-hidden">
            <div class="position-relative d-flex align-items-center p-2 bg-light">
                <div>
                    <i class="fa fa-file-image fs-xl"></i>
                </div>
                <div class="ms-2">
                    <?=$image['title']?>
                </div>
                <input class="position-absolute cover fs-xxl opacity-0" type="file" onchange="onFileChange(event, '<?=$image["field"]?>')">
            </div>
            <div class="hint"><?=$image['desc']?></div>

            <?php
            $src = '';
            $file = files();
            if ( $post->v($image['field']) ) {
                $file = files($post->v($image['field']));
            }
            ?>

            <div class="position-relative">
                <img id="<?=$image['field']?>Src" src="<?=$file?->url?>" class="mw-100" onclick="onClickFileDelete(<?=$file?->idx?>, '<?=$image["field"]?>');">
            </div>

        </div>
        <?php } ?>


        <div class="d-flex justify-content-between mt-2 mb-3">
            <div>
                <button type="submit" class="btn btn-primary">
                    저장
                </button>
                <button class="ml-2 btn btn-danger" type="submit" name="button" value="delete" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</button>
            </div>
        </div>


    </form>
</section>

<script>
    function onFileChange(event, id) {
        const file = event.target.files[0];
        fileUpload(
            file,
            {
                sessionId: '<?=login()->sessionId?>',
            },
            function (res) {
                console.log("success: res.path: ", res, res.path);
                const $input = document.getElementById(id);
                $input.value = res.idx;
                const $img = document.getElementById(id + 'Src');
                $img.src = res.url;
            },
            alert,
            function (p) {
                console.log("pregoress: ", p);
            }
        );
    }

    function onClickFileDelete(idx, id) {
        const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
        if ( re === false ) return;
        axios.post('/index.php', {
            sessionId: '<?=login()->sessionId?>',
            route: 'file.delete',
            idx: idx,
        })
            .then(function (res) {
                const $input = document.getElementById(id);
                $input.value = '';
                const $img = document.getElementById(id + 'Src');
                $img.src = '';
            })
            .catch(alert);
    }
</script>


<script src="<?php echo HOME_URL?>/etc/js/vue.3.0.7.global.prod.min.js"></script>
<script>
    const app = Vue.createApp({
        data() {
            return {
                discountedPrice: 0,
                post: <?=json_encode($post->getData())?>,
            }
        },
        created() {
            this.onPriceChange();
        },
        methods: {
            onPriceChange() {
                if ( this.post.price && this.post.discountRate ) {
                    this.discountedPrice = Math.round(this.post.price - this.post.price * this.post.discountRate / 100);
                } else {
                    this.discountedPrice = 0;
                }
            },
        }
    }).mount("#app");
</script>
