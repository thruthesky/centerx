<?php
    $cat = category(in(ID))->get(cache: false);

?>
<form action="/" method="post">
    <input type="hidden" name="p" value="admin.index">
    <input type="hidden" name="w" value="category/admin-category-list">
    <input type="hidden" name="mode" value="update">
    <input type="hidden" name="<?=ID?>" value="<?=in(ID)?>">




    <table class="table">
        <thead>
        <tr>
            <th scope="col">옵션</th>
            <th scope="col">설정</th>
        </tr>
        </thead>
        <tbody>


        <tr>
            <td><?=ln('Title', '게시판 제목')?></td>
            <td>
                <input name="<?=TITLE?>" value="<?= $cat[TITLE] ?>">
            </td>
        </tr>

        <tr>
            <td><?=ln('Description', '설명')?></td>
            <td>
                <input name="<?=DESCRIPTION?>" value="<?= $cat[DESCRIPTION] ?>">
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2">카테고리 설정</td>
        </tr>
        <tr class="table-light">
            <td colspan="2">
                <div class="hint">
                    콤마로 여러개의 카테고리를 입력할 수 있습니다.
                </div>
            </td>
        </tr>

        <tr>
            <td><?=ln('Description', '설명')?></td>
            <td>
                <input name="subcategories" value="<?= implode(',', $cat['subcategories']) ?>">
            </td>
        </tr>



        <tr class="table-dark">
            <td colspan="2">포인트 설정</td>
        </tr>
        <tr class="table-light">
            <td colspan="2">
                <div class="hint">
                    포인트 설정에서 삭제 포인트는 음수 값만 입력 할 수 있습니다.
                </div>
            </td>
        </tr>

        <tr>
            <td><?=ln('Post Create Point', '글 쓰기 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_POST_CREATE?>" value="<?=$cat[ POINT_POST_CREATE ]?>">
            </td>
        </tr>
        <tr>
            <td><?=ln('Point Delete Point', '글 삭제 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_POST_DELETE?>" value="<?=$cat[ POINT_POST_DELETE ]?>">
            </td>
        </tr>

        <tr>
            <td><?=ln('Comment Create Point', '코멘트 쓰기 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_COMMENT_CREATE?>" value="<?=$cat[POINT_COMMENT_CREATE]?>">
            </td>
        </tr>
        <tr>
            <td><?=ln('Comment Delete Point', '코멘트 삭제 포인트')?></td>
            <td>
                <input type="number" name="<?=POINT_COMMENT_DELETE?>" value="<?=$cat[POINT_COMMENT_DELETE]?>">
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2">제한 설정</td>
        </tr>
        <tr class="table-light">
            <td colspan="2">
                <div class="hint">
                    포인트 설정 및 글 쓰기 제한. 포인트에는 기본 적용됩니다.
                </div>
            </td>
        </tr>

        <tr>
            <td><?=ln('Hour/Count Limit', '시간/수 제한')?></td>
            <td>
                <input class="w-25" type="number" name="<?=POINT_HOUR_LIMIT?>" value="<?=$cat[POINT_HOUR_LIMIT]?>">
                /
                <input class="w-25" type="number" name="<?=POINT_HOUR_LIMIT_COUNT?>" value="<?=$cat[POINT_HOUR_LIMIT_COUNT]?>">
            </td>
        </tr>
        <tr>
            <td><?=ln('Day/Count Limit', '일/수 제한')?></td>
            <td>
                <input class="w-25" type="number" name="<?=POINT_DAILY_LIMIT_COUNT?>" value="<?=$cat[POINT_DAILY_LIMIT_COUNT]?>">
            </td>
        </tr>



        <tr>
            <td><?=ln('Ban on Creation', '글/코멘트에 제한')?></td>
            <td>
                <label>
                    <input
                        type="radio"
                        name="<?=BAN_ON_LIMIT?>"
                        value="Y"
                        <?php if ($cat[BAN_ON_LIMIT] == 'Y' ) echo 'checked' ?>> 예,
                </label>
                &nbsp;
                <label>
                    <input
                        type="radio"
                        name="<?=BAN_ON_LIMIT?>"
                        value="N"
                        <?php if ($cat[BAN_ON_LIMIT] != 'Y' ) echo 'checked' ?>> 아니오
                </label>
            </td>
        </tr>




        <tr class="table-dark">
            <td colspan="2">웹 위젯 설정</td>
        </tr>

        <tr>
            <td><?=ln('Post Edit Widget', '글 수정 위젯')?></td>
            <td>
                <?php select_list_widgets($cat[ID], 'post-edit', 'postEditWidget'); ?>
            </td>
        </tr>




        <tr>
            <td><?=ln('Post View Widget', '글 읽기 위젯')?></td>
            <td>
                <?php select_list_widgets($cat[ID], 'post-view', 'postViewWidget'); ?>
            </td>
        </tr>




        <tr>
            <td><?=ln('Forum List Header', '글 목록 헤더 위젯')?></td>
            <td>
                <?php select_list_widgets($cat[ID], 'post-list-header', 'postListHeaderWidget'); ?>
            </td>
        </tr>



        <tr>
            <td><?=ln('Forum List Widget', '글 목록 위젯')?></td>
            <td>
                <?php select_list_widgets($cat[ID], 'post-list', 'postListWidget'); ?>
            </td>
        </tr>


        <tr>
            <td><?=ln('Forum List Pagination Widget', '네비게이션 위젯')?></td>
            <td>
                <?php
                select_list_widgets($cat[ID], 'pagination', 'paginationWidget');
                ?>
            </td>
        </tr>






        <tr>
            <td><?=ln('Post list under view page', '글 읽기 아래 목록')?></td>
            <td>
                <label>
                    <input
                        type="radio"
                        name="listOnView"
                        value="Y"
                        <?php if ($cat['listOnView'] == 'Y' ) echo 'checked' ?>> 예,
                </label>
                &nbsp;
                <label>
                    <input
                        type="radio"
                        name="listOnView"
                        value="N"
                        <?php if ($cat['listOnView'] != 'Y' ) echo 'checked' ?>> 아니오
                </label>
            </td>
        </tr>
        <tr>
            <td><?=ln('No of posts per page', '페이지 글 수')?></td>
            <td>
                <input
                    name="noOfPostsPerPage"
                    type="text"
                    value="<?=$cat['noOfPostsPerPage']?>">
            </td>
        </tr>
        <tr>
            <td nowrap><?=ln('No of pages on navigator', '네이게이션 페이지 수')?></td>
            <td>
                <input
                    name="noOfPagesOnNav"
                    type="text"
                    value="<?=$cat['noOfPagesOnNav']?>">
            </td>
        </tr>


        <tr class="table-dark">
            <td colspan="2"><?=ln('App Widgets', '앱 위젯 설정')?></td>
        </tr>

        <tr>
            <td><?=ln('Post List Widget', '글 목록 위젯')?></td>
            <td>
                <label class="">
                    <input
                        type="radio"
                        name="mobilePostListWidget"
                        value="text"
                        <?php if ($cat['mobilePostListWidget'] == 'text' ) echo 'checked' ?>> <?=ln('Text', '텍스트')?>
                </label>
                <label class="ps-2">
                    <input
                        type="radio"
                        name="mobilePostListWidget"
                        value="gallery"
                        <?php if ($cat['mobilePostListWidget'] == 'gallery' ) echo 'checked' ?>> <?=ln('Gallery', '갤러리')?>
                </label>

                <label class="ps-2">
                    <input
                        type="radio"
                        name="mobilePostListWidget"
                        value="thumbnail"
                        <?php if ($cat['mobilePostListWidget'] == 'thumbnail' ) echo 'checked' ?>> <?=ln('Thumbnail', '썸네일')?>
                </label>

            </td>
        </tr>

        <tr>
            <td><?=ln('Post View Widget', '글 읽기 위젯')?></td>
            <td>
                <label class="">
                    <input
                        type="radio"
                        name="mobilePostViewWidget"
                        value="default"
                        <?php if ($cat['mobilePostViewWidget'] == 'default' ) echo 'checked' ?>> <?=ln('Default', '기본')?>
                </label>
                <label class="ps-2">
                    <input
                        type="radio"
                        name="mobilePostViewWidget"
                        value="slide"
                        <?php if ($cat['mobilePostViewWidget'] == 'slide' ) echo 'checked' ?>> <?=ln('Slide', '슬라이드')?>
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