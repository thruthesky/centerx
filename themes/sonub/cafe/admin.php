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


    <div class="form-group bg-light p-3">
        <h2><?=ln('app_installation')?></h2>
        <small class="form-text text-muted"><?=ln('app_installation_description')?></small>

        <label><?=ln('cafe_app_icon')?></label>
        <upload-image taxonomy="<?=cafe()->taxonomy?>" entity="<?=cafe()->idx?>" code="app_icon"></upload-image>
        <small class="form-text text-muted">
            <?=ln('cafe_app_icon_description')?>
        </small>

        <label for="cafe_app_name"><?=ln('cafe_app_name')?></label>
        <input type="text" class="form-control" id="cafe_app_name" name="app_name" value="<?=cafe()->app_name?>">
        <small class="form-text text-muted"><?=ln('cafe_app_name_description')?></small>


        <label for="cafe_app_background_color"><?=ln('cafe_app_background_color')?></label>
        <select class="custom-select" id="cafe_app_background_color" name="app_background_color" >
            <option selected><?=ln('select_color')?></option>
            <option value="red" <?=cafe()->app_background_color == 'red' ? 'selected' : ''?>><?=ln('red')?></option>
            <option value="green" <?=cafe()->app_background_color == 'green' ? 'selected' : ''?>><?=ln('green')?></option>
            <option value="blue" <?=cafe()->app_background_color == 'blue' ? 'selected' : ''?>><?=ln('blue')?></option>
        </select>

        <small class="form-text text-muted"><?=ln('cafe_app_background_color_description')?></small>

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

