<?php

if (modeCreate()) {
    $created = category()->create([ID => in('id')]);
    if ($created->hasError) {
        if ($created->getError() == e()->category_exists) {
        } else {
            jsBack($created->getError());
        }
    }
} else if (modeUpdate()) {
    $re = category(in('id'))->update(in());
    if ( $re->hasError ) jsAlert($re->getError());
} else if (modeDelete()) {
    category(in('id'))->delete();
}

$editCategory = in(ID) && modeDelete() == false;
if ($editCategory) {
    $lw = 6;
    $rw = 6;
} else {
    $lw = 4;
    $rw = 8;
}

?>

<div class="container">
    <div class="row">
        <div class="col-<?= $lw ?>">
            <?php if ($editCategory) {
            ?>
                <h3 class="mb-3 pt-1"><?= ek('Category Update', '@T Category Update') ?></h3>
                <?php
                include 'sidebar.php';
                ?>
            <?php } else { ?>
                <h3>Category</h3>
            <?php } ?>
            <ul class="fs-sm border-radius-sm px-4 py-2" style="border: 1px solid #e8e8e8;">
                <li class="fw-700"><?= ek('Click id to update.', '@T Click id to update.') ?></li>
                <li class="mt-2"><?= ek(
                        'If you click the "Create or Edit" button, the category is created if it does not exist, and if it does, it will be edited.
                    However, it is recommended to use it only when creating categories.
                    For reference, you can edit a category by clicking on the ID shown in the table.',
                        '"생성 또는 수정" 버튼을 클릭하면, 카테고리가 존재하지 않는 경우 생성을 하며, 존재하는 경우 수정을 합니다.
                    하지만, 카테고리 생성을 할 때만 사용하는 것이 좋습니다.
                    참고로, 카테고리 수정은 테이블에 나와있는 아이디를 클릭하면 수정을 할 수 있습니다.',
                    ) ?>
                </li>
            </ul>
        </div>
        <div class="col-<?= $rw ?>">
            <section class="w-100">
                <form>
                    <input type="hidden" name="p" value="admin.index">
                    <input type="hidden" name="w" value="category/admin-category-list">
                    <input type="hidden" name="mode" value="create">
                    <div class="d-flex">
                        <input data-cy="category-input" class="form-control mb-2" type="text" name='id' placeholder="<?= ek('Enter Category ID','카테고리 아이디 입력') ?>">
                        <button data-cy="category-submit" class="btn btn-primary ml-3 mb-2 w-50" type="submit"><?= ek('Create','생성') ?></button>
                    </div>
                </form>
            </section>

            <table class="table table-striped mt-2">
                <thead class="thead-dark">
                    <tr class="fs-sm">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col"><?= ek('Title', '@T Title') ?></th>
                        <th scope="col"><?= ek('Description', '@T Description') ?></th>
                        <th scope="col"><?= ek('Action', '@T Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (ids(category()->search(limit: 200)) as $idx) {
                        $category = category($idx) ?>

                        <tr>
                            <th scope="row"><a data-cy="<?= $category->id ?>" href="/?p=forum.post.list&categoryId=<?= $category->id ?>" target="_blank"><?= $category->idx ?></a></th>
                            <td><a href="/?p=admin.index&w=category/admin-category-list&id=<?= $category->id ?>"><?= $category->id ?></a></td>
                            <td><span data-cy="category-<?= $category->id ?>-title"><?= $category->title ?></span></td>
                            <td><span data-cy="category-<?= $category->id ?>-description"><?= $category->description ?></span></td>
                            <td class="justify-content-center"><a class="btn btn-sm btn-outline-danger" data-cy="<?= $category->id ?>-delete" href="/?admin.index&w=<?= in('w') ?>&mode=delete&id=<?= $category->id ?>" onclick="return confirm('Delete the category?')">❌</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>