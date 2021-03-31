<?php
    $category = category(in(ID));

?>
<form action="/" method="post">
    <input type="hidden" name="p" value="admin.index">
    <input type="hidden" name="w" value="category/admin-category-list">
    <input type="hidden" name="mode" value="update">
    <input type="hidden" name="<?=ID?>" value="<?=in(ID)?>">


    <table class="table">
        <thead>
        <tr>
            <th scope="col"><?=ln(['ko'=>'옵션', 'en'=>'Option'])?></th>
            <th scope="col"><?=ek('Setting', '설정')?></th>
        </tr>
        </thead>
        <tbody>


        <tr>
            <td><?=ln(['en' => 'Category ID', 'ko' => '카테고리 ID'])?></td>
            <td>
                <?= $category->id ?>
            </td>
        </tr>

        <tr>
            <td><?=ek('Title', '게시판 제목')?></td>
            <td>
                <input name="<?=TITLE?>" value="<?= $category->title ?>">
            </td>
        </tr>

        <tr>
            <td><?=ek('Description', '설명')?></td>
            <td>
                <input name="<?=DESCRIPTION?>" value="<?= $category->description ?>">
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2"><?=ek('Subcategories', '서브 카테고리 설정')?></td>
        </tr>
        <tr class="table-light">
            <td colspan="2">
                <div class="hint">
                    <?=ek('Add multi categories separating by comma.', '콤마로 여러개의 카테고리를 입력할 수 있습니다.')?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?=ek('Subcategories', '서브 카테고리')?></td>
            <td>
                <input name="subcategories" value="<?= implode(',', $category->subcategories) ?>">
            </td>
        </tr>



        <tr class="table-dark">
            <td colspan="2"><?=ek('Point settings', '포인트 설정')?></td>
        </tr>
        <tr class="table-light">
            <td colspan="2">
                <div class="hint">
                    <?=ek('Point for deletion must be set to 0 or negative value.', '포인트 설정에서 삭제 포인트는 0 또는 음수 값만 입력 할 수 있습니다.')?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?=ek('Post Create Point', '글 쓰기 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_POST_CREATE?>" value="<?=$category->POINT_POST_CREATE?>">
            </td>
        </tr>
        <tr>
            <td><?=ek('Point Delete Point', '글 삭제 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_POST_DELETE?>" value="<?= $category->POINT_POST_DELETE ?>">
            </td>
        </tr>

        <tr>
            <td><?=ek('Comment Create Point', '코멘트 쓰기 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_COMMENT_CREATE?>" value="<?=$category->POINT_COMMENT_CREATE?>">
            </td>
        </tr>
        <tr>
            <td><?=ek('Comment Delete Point', '코멘트 삭제 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_COMMENT_DELETE?>" value="<?=$category->POINT_COMMENT_DELETE?>">
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2"><?=ek('Limitation settings', '제한 설정')?></td>
        </tr>
        <tr class="table-light">
            <td colspan="2">
                <div class="hint">

                    <?=ek('When the limitation below happens, point will not be increase or decreased. But the user can continue writing posts and comments. And if `Ban on writing` is checked, then the user can no longer be able to write post or comments.',
                        '아래의 제한 설정에 걸리면 포인트 증/감이 발생하지 않습니다. 다만, 글/코멘트는 계속 쓸 수 있는데, 아래의 글/코멘트 제한을 하면, 글/코멘트도 못 쓰게 됩니다.')?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?=ek('Hour/Count Limit', '시간/수 제한')?></td>
            <td>
                <input class="w-25" type="number" name="<?=POINT_HOUR_LIMIT?>" value="<?=$category->POINT_HOUR_LIMIT?>">
                /
                <input class="w-25" type="number" name="<?=POINT_HOUR_LIMIT_COUNT?>" value="<?=$category->POINT_HOUR_LIMIT_COUNT?>">
            </td>
        </tr>
        <tr>
            <td><?=ek('Day/Count Limit', '일/수 제한')?></td>
            <td>
                <input class="w-25" type="number" name="<?=POINT_DAILY_LIMIT_COUNT?>" value="<?=$category->POINT_DAILY_LIMIT_COUNT?>">
            </td>
        </tr>

        <tr>
            <td><?=ek('Ban on wriiting', '글/코멘트에 제한')?></td>
            <td>
                <label>
                    <input
                        type="radio"
                        name="<?=BAN_ON_LIMIT?>"
                        value="Y"
                        <?php if ($category->BAN_ON_LIMIT == 'Y' ) echo 'checked' ?>> <?=ek('Yes', '예')?>,
                </label>
                &nbsp;
                <label>
                    <input
                        type="radio"
                        name="<?=BAN_ON_LIMIT?>"
                        value="N"
                        <?php if ($category->BAN_ON_LIMIT != 'Y' ) echo 'checked' ?>> <?=ek('No', '아니오')?>
                </label>
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2"><?=ek('Return to', '게시판 동작 설정')?></td>
        </tr>

        <tr>
            <td><?=ek('Return To After Edit', '글 편집 후 이동')?></td>
            <td>
                <label>
                    <input
                            type="radio"
                            name="returnToAfterPostEdit"
                            value="V"
                        <?php if ($category->returnToAfterPostEdit == 'V' || empty($category->returnToAfterPostEdit) ) echo 'checked' ?>> <?=ek('Post view page', '글 읽기 페이지')?>,
                </label>
                &nbsp;
                <label>
                    <input
                            type="radio"
                            name="returnToAfterPostEdit"
                            value="L"
                        <?php if ($category->returnToAfterPostEdit == 'L' ) echo 'checked' ?>> <?=ek('Post list page', '글 목록 페이지')?>
                </label>
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2"><?=ek('Widgets (web)', '웹 위젯 설정')?></td>
        </tr>

        <tr>
            <td><?=ek('Post Edit Widget', '글 수정 위젯')?></td>
            <td>
                <?php select_list_widgets($category->idx, 'post-edit', 'postEditWidget'); ?>
            </td>
        </tr>


        <tr>
            <td><?=ek('Post View Widget', '글 읽기 위젯')?></td>
            <td>
                <?php select_list_widgets($category->idx, 'post-view', 'postViewWidget'); ?>
            </td>
        </tr>




        <tr>
            <td><?=ek('Forum List Header', '글 목록 헤더 위젯')?></td>
            <td>
                <?php select_list_widgets($category->idx, 'post-list-header', 'postListHeaderWidget'); ?>
            </td>
        </tr>



        <tr>
            <td><?=ek('Forum List Widget', '글 목록 위젯')?></td>
            <td>
                <?php select_list_widgets($category->idx, 'post-list', 'postListWidget'); ?>
            </td>
        </tr>


        <tr>
            <td><?=ek('Forum List Pagination Widget', '네비게이션 위젯')?></td>
            <td>
                <?php
                select_list_widgets($category->idx, 'pagination', 'paginationWidget');
                ?>
            </td>
        </tr>






        <tr>
            <td><?=ek('Post list under view page', '글 읽기 아래 목록')?></td>
            <td>
                <label>
                    <input
                        type="radio"
                        name="listOnView"
                        value="Y"
                        <?php if ($category->listOnView == 'Y' ) echo 'checked' ?>> <?=ek('Yes', '예')?>,
                </label>
                &nbsp;
                <label>
                    <input
                        type="radio"
                        name="listOnView"
                        value="N"
                        <?php if ($category->listOnView != 'Y' ) echo 'checked' ?>>  <?=ek('No', '아니오')?>
                </label>
            </td>
        </tr>
        <tr>
            <td><?=ek('No of posts per page', '페이지 글 수')?></td>
            <td>
                <input
                    name="noOfPostsPerPage"
                    type="text"
                    value="<?=$category->noOfPostsPerPage?>">
            </td>
        </tr>
        <tr>
            <td nowrap><?=ek('No of pages on navigator', '네이게이션 페이지 수')?></td>
            <td>
                <input
                    name="noOfPagesOnNav"
                    type="text"
                    value="<?=$category->noOfPagesOnNav?>">
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2"><?=ek('App Widgets', '앱 위젯 설정')?></td>
        </tr>

        <tr>
            <td><?=ln(['en' => 'Post List Widget', 'ko' => '글 목록 위젯'])?></td>
            <td>
                <label class="">
                    <input
                        type="radio"
                        name="mobilePostListWidget"
                        value="text"
                        <?php if ($category->mobilePostListWidget == 'text' ) echo 'checked' ?>> <?=ln(['en' => 'Text', 'ko' => '텍스트'])?>
                </label>
                <label class="ps-2">
                    <input
                        type="radio"
                        name="mobilePostListWidget"
                        value="gallery"
                        <?php if ($category->mobilePostListWidget == 'gallery' ) echo 'checked' ?>> <?=ln(['en' => 'Gallery',  'ko' => '갤러리'])?>
                </label>

                <label class="ps-2">
                    <input
                        type="radio"
                        name="mobilePostListWidget"
                        value="thumbnail"
                        <?php if ($category->mobilePostListWidget == 'thumbnail' ) echo 'checked' ?>> <?=ln(['en' => 'Thumbnail',  'ko' => '썸네일'])?>
                </label>

            </td>
        </tr>

        <tr>
            <td><?=ln(['en' => 'Post View Widget', 'ko' => '글 읽기 위젯'])?></td>
            <td>
                <label class="">
                    <input
                        type="radio"
                        name="mobilePostViewWidget"
                        value="default"
                        <?php if ($category->mobilePostViewWidget == 'default' ) echo 'checked' ?>> <?=ln(['en' => 'Default', 'ko' => '기본'])?>
                </label>
                <label class="ps-2">
                    <input
                        type="radio"
                        name="mobilePostViewWidget"
                        value="slide"
                        <?php if ($category->mobilePostViewWidget == 'slide' ) echo 'checked' ?>> <?=ln(['en' => 'Slide', 'ko' => '슬라이드'])?>
                </label>

            </td>
        </tr>



        <tr>
            <td></td>
            <td>
                <button type="submit">Submit</button>
            </td>
        </tr>
        </tbody>
    </table>


</form>