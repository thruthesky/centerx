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
                <?=ln('cafe_title_image_description')?>
            </small>
    </div>

    <div class="form-group">
        <label for="categoryBox"><?=ln('category')?></label>
        <input type="text" class="form-control" id="categoryBox" name="subcategories" value="<?=cafe()->orgSubcategories?>">
        <small class="form-text text-muted">
            <?=ln('cafe_category_description')?>
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

