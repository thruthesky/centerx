<h1><?=ln('cafe_admin')?></h1>

<form action="/" method="post">
    <?=hiddens([], 'update', 'cafe.admin.submit', kvs: [IDX => cafe()->idx] )?>
    <div class="form-group">
        <label for="categoryTitle"><?=ln('cafe_name')?></label>
        <input type="text" class="form-control" id="categoryTitle" name="title" value="<?=cafe()->title?>">
        <small class="form-text text-muted">
            카페 이름을 입력해주세요.
        </small>
    </div>

    <div class="form-group">
        <label for="categoryTitle"><?=ln('cafe_description')?></label>
        <input type="text" class="form-control" id="categoryTitle" name="description" value="<?=cafe()->description?>">
        <small class="form-text text-muted">
            카페 이름을 입력해주세요.
        </small>
    </div>

    <div class="form-group">
        <label><?=ln('cafe_title_image')?></label>
            <upload-image taxonomy="<?=cafe()->taxonomy?>" entity="<?=cafe()->idx?>" code="title_image"></upload-image>
            <small class="form-text text-muted">
                카페 로고 사진을 등록해주세요. 사이즈는 너비 1400 픽셀, 높이 200 픽셀, 용량 100Kb 이하로 해 주세요.
            </small>
    </div>

    <div class="form-group">
        <label for="categoryBox">카테고리</label>
        <input type="text" class="form-control" id="categoryBox" name="subcategories" value="<?=cafe()->orgSubcategories?>">
        <small class="form-text text-muted">
            콤마로 분리하여 여러개 입력 가능. 예) 속보,날씨,사회,경제,정보마당,부동산컬럼
        </small>
    </div>


    <div class="form-group">
        <label><?=ln('cafe_app_icon')?></label>
        <upload-image taxonomy="<?=cafe()->taxonomy?>" entity="<?=cafe()->idx?>" code="app_icon"></upload-image>
        <small class="form-text text-muted">
            <?=ln('cafe_app_icon_description')?>
        </small>
    </div>



    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<style>
    .uploaded-image img {
        width: 100%;
    }
    .upload-button {
        margin-top: .5em;
    }
</style>
<?php js('/etc/js/vue-js-components/upload-image.js')?>

