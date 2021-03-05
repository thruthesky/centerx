<?php

if ( modeCreate() ) {
    $re = category()->create([ID=>in('id')]);
} else if ( modeUpdate() ) {
    $re = category(in('id'))->update(in());
} else if ( modeDelete() ) {
    category(in('id'))->delete();
}

?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <?php if ( in(ID) && modeDelete() == false ) {
                $cat = category(in(ID))->get();
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
            </ul>
        </div>
        <div class="col-6">
            <section class="mx-5">
                <form>
                    <input type="hidden" name="p" value="admin.index">
                    <input type="hidden" name="w" value="category/admin-category-list">
                    <input type="hidden" name="mode" value="create">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" name='id' placeholder="카테고리 아이디 입력">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">Create</button>
                        </div>
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
                <?php foreach( categories() as $cat ) { ?>

                    <tr>
                        <th scope="row"><?=$cat[IDX]?></th>
                        <td><a href="/?p=admin.index&w=category/admin-category-list&id=<?=$cat[ID]?>"><?=$cat[ID]?></a></td>
                        <td><?=$cat[TITLE]?></td>
                        <td><?=$cat[DESCRIPTION]?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>