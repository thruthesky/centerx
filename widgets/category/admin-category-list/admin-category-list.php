<?php

if ( modeCreate() ) {
    $re = category()->create([ID=>in('id')]);
} else if ( modeUpdate() ) {
    $re = category(in('id'))->update(in());
} else if ( modeDelete() ) {
    category(in('id'))->delete();
}

$editCategory = in(ID) && modeDelete() == false;
if ( $editCategory ) {
    $lw = 6;
    $rw = 6;
} else {
    $lw = 4;
    $rw = 8;
}

?>

<div class="container">
    <div class="row">
        <div class="col-<?=$lw?>">
            <?php if ( $editCategory ) {
                ?>
                    <h3>Category Update</h3>
                <?php
                include 'sidebar.php';
                ?>
            <?php } else { ?>
                <h3>Category</h3>
            <?php } ?>
            <ul>
                <li>Click id to update.</li>
                <li>
                    "생성 또는 수정" 버튼을 클릭하면, 카테고리가 존재하지 않는 경우 생성을 하며, 존재하는 경우 수정을 합니다.
                    하지만, 카테고리 생성을 할 때만 사용하는 것이 좋습니다.
                    참고로, 카테고리 수정은 테이블에 나와있는 아이디를 클릭하면 수정을 할 수 있습니다.
                </li>
            </ul>
        </div>
        <div class="col-<?=$rw?>">
            <section class="w-100">
                <form>
                    <input type="hidden" name="p" value="admin.index">
                    <input type="hidden" name="w" value="category/admin-category-list">
                    <input type="hidden" name="mode" value="create">
                    <div class="d-flex">
                        <input class="form-control mb-2" type="text" name='id' placeholder="카테고리 아이디 입력">
                        <button class="btn btn-primary ml-3 mb-2 w-50" type="submit" ><?=ln(['en' => 'Create or Update', 'ko' => '생성 또는 수정'])?></button>
                    </div>
                </form>
            </section>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">DESCRIPTION</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach( category()->search( limit: 100 ) as $category ) { ?>

                    <tr>
                        <th scope="row"><a href="/?p=forum.post.list&categoryId=<?=$category->id?>" target="_blank"><?=$category->idx?></a></th>
                        <td><a href="/?p=admin.index&w=category/admin-category-list&id=<?=$category->id?>"><?=$category->id?></a></td>
                        <td><?=$category->title?></td>
                        <td><?=$category->description?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>