<h1>카페 관리자 페이지</h1>

<form action="/" method="post">
    <?=hiddens([], 'update', ['idx' => cafe()->idx], 'cafe.admin.submit')?>
    <div class="form-group">
        <label for="categoryTitle">카페 제목</label>
        <input type="text" class="form-control" id="categoryTitle" name="title" value="<?=cafe()->title?>">
        <small class="form-text text-muted">
            카페 제목 또는 이름을 입력해주세요.
        </small>
    </div>

    <div class="form-group">
        <label for="categoryBox">카테고리</label>
        <input type="text" class="form-control" id="categoryBox" name="subcategories" value="<?=cafe()->orgSubcategories?>">
        <small class="form-text text-muted">
            콤마로 분리하여 여러개 입력 가능. 예) 속보,날씨,사회,경제,정보마당,부동산컬럼
        </small>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>