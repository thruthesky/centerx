<?php
$category = category(in(ID));

?>
<form data-cy="form" action="/" method="post">
    <input type="hidden" name="p" value="admin.index">
    <input type="hidden" name="w" value="category/admin-category-list">
    <input type="hidden" name="mode" value="update">
    <input type="hidden" name="<?= ID ?>" value="<?= in(ID) ?>">

    <table class="table">
        <thead class="fs-sm">
            <tr class="thead-light">
                <th scope="col"><?= ln('option') ?></th>
                <th scope="col"><?= ln('setting') ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= ln('category_id') ?></td>
                <td>
                    <?= $category->id ?>
                </td>
            </tr>

            <tr>
                <td><?= ln('title') ?></td>
                <td>
                    <input data-cy="form-title" class="form-control" name="<?= TITLE ?>" value="<?= $category->title ?>">
                </td>
            </tr>

            <tr>
                <td><?= ln('description') ?></td>
                <td>
                    <input data-cy="form-description" class="form-control" name="<?= DESCRIPTION ?>" value="<?= $category->description ?>">
                </td>
            </tr>


            <tr class="table-dark fs-sm">
                <td colspan="2"><?= ln('subcategories') ?></td>
            </tr>
            <tr class="table-light">
                <td colspan="2">
                    <div class="hint">
                        <?= ln('subcategories_hint') ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea data-cy="form-subcategories" class="w-100 form-control" rows="3" name="subcategories"><?= implode(',', $category->subcategories) ?></textarea>
                </td>
            </tr>


            <tr class="table-dark">
                <td colspan="2"><?= ln('point_settings') ?></td>
            </tr>
            <tr class="table-light">
                <td colspan="2">
                    <div class="hint">
                        <?= ln('point_settings_hint') ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td><?= ln('post_create_point') ?></td>
                <td>
                    <input data-cy="form-post-create-point" class="form-control" type="number" name="<?= Actions::$createPost ?>" value="<?= $category->createPost ?>">
                </td>
            </tr>
            <tr>
                <td><?= ln('post_delete_point') ?></td>
                <td>
                    <input data-cy="form-post-delete-point" class="form-control" type="number" name="<?= Actions::$deletePost ?>" value="<?= $category->deletePost ?>">
                </td>
            </tr>

            <tr>
                <td><?= ln('comment_create_point') ?></td>
                <td>
                    <input data-cy="form-comment-create-point" class="form-control" type="number" name="<?= Actions::$createComment ?>" value="<?= $category->createComment ?>">
                </td>
            </tr>
            <tr>
                <td><?= ln('comment_delete_point') ?></td>
                <td>
                    <input data-cy="form-comment-delete-point" class="form-control" type="number" name="<?= Actions::$deleteComment ?>" value="<?= $category->deleteComment ?>">
                </td>
            </tr>


            <tr class="table-dark">
                <td colspan="2"><?= ln('limit_by_hour_day') ?></td>
            </tr>
            <tr class="table-light">
                <td colspan="2">
                    <div class="hint">
                        <?= ln('limit_by_hour_day_hint') ?>
                    </div>
                </td>
            </tr>


            <tr>
                <td><?= ln('hour_count_limit') ?></td>
                <td class="d-flex align-items-center">
                    <input data-cy="form-create-hour-limit" class="w-25 form-control" type="number" name="<?= ActivityLimits::$createHourLimit ?>" value="<?= $category->createHourLimit ?>">
                    <span class="mx-2">/</span>
                    <input data-cy="form-create-hour-limit-count" class="w-25 form-control" type="number" name="<?= ActivityLimits::$createHourLimitCount ?>" value="<?= $category->createHourLimitCount ?>">
                </td>
            </tr>
            <tr>
                <td><?= ln('day_count_limit') ?></td>
                <td>
                    <input data-cy="form-create-daily-limit-count" class="w-25 form-control" type="number" name="<?= ActivityLimits::$createDailyLimitCount ?>" value="<?= $category->createDailyLimitCount ?>">
                </td>
            </tr>

            <tr>
                <td><?= ln('ban_on_writing') ?></td>
                <td>
                    <label>
                        <input data-cy="form-ban-create-on-limit-Y" type="radio" name="<?= ActivityLimits::$banCreateOnLimit ?>" value="Y" <?php if ($category->banCreateOnLimit == 'Y') echo 'checked' ?>> <?= ek('Yes', '예') ?>,
                    </label>
                    &nbsp;
                    <label>
                        <input data-cy="form-ban-create-on-limit-N" type="radio" name="<?= ActivityLimits::$banCreateOnLimit ?>" value="N" <?php if ($category->banCreateOnLimit != 'Y') echo 'checked' ?>> <?= ek('No', '아니오') ?>
                    </label>
                </td>
            </tr>




            <tr class="table-dark">
                <td colspan="2"><?= ln('limit_by_point_possession') ?></td>
            </tr>
            <tr class="table-light">
                <td colspan="2">
                    <div class="hint">
                        <?= ln('limit_by_point_possession_hint') ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td><?= ln('post_create_limit') ?></td>
                <td>
                    <input data-cy="form-post-create-limit" class="form-control" name="postCreateLimit" value="<?= $category->postCreateLimit ?>">
                </td>
            </tr>


            <tr>
                <td><?= ln('comment_create_limit') ?></td>
                <td>
                    <input data-cy="form-comment-create-limit" class="form-control" name="commentCreateLimit" value="<?= $category->commentCreateLimit ?>">
                </td>
            </tr>


            <tr>
                <td><?= ln('post_comment_read_limit') ?></td>
                <td>
                    <input data-cy="form-read-limit" class="form-control" name="readLimit" value="<?= $category->readLimit ?>">
                </td>
            </tr>





            <tr class="table-dark">
                <td colspan="2"><?= ln('return_to') ?></td>
            </tr>

            <tr>
                <td><?= ek('Return To After Edit', '글 편집 후 이동') ?></td>
                <td>
                    <label>
                        <input data-cy="form-return-to-after-post-edit-V" type="radio" name="returnToAfterPostEdit" value="V" <?php if ($category->returnToAfterPostEdit == 'V' || empty($category->returnToAfterPostEdit)) echo 'checked' ?>> <?= ek('Post view page', '글 읽기 페이지') ?>,
                    </label>
                    &nbsp;
                    <label>
                        <input data-cy="form-return-to-after-post-edit-L" type="radio" name="returnToAfterPostEdit" value="L" <?php if ($category->returnToAfterPostEdit == 'L') echo 'checked' ?>> <?= ek('Post list page', '글 목록 페이지') ?>
                    </label>
                </td>
            </tr>


            <tr class="table-dark">
                <td colspan="2"><?= ek('Widgets (web)', '웹 위젯 설정') ?></td>
            </tr>

            <tr>
                <td><?= ek('Post Edit Widget', '글 수정 위젯') ?></td>
                <td>
                    <?php select_list_widgets($category->idx, 'post-edit', 'postEditWidget'); ?>
                </td>
            </tr>


            <tr class="table-light">
                <td colspan="2">
                    <div class="hint">
                        <?= ek('Input post edit widget options', '글 생성/수정 옵션을 입력하세요.') ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <textarea class="w-100" rows="5" name="postEditWidgetOption"><?= $category->postEditWidgetOption ?></textarea>
                </td>
            </tr>
            <tr>
                <td><?= ek('Post View Widget', '글 읽기 위젯') ?></td>
                <td>
                    <?php select_list_widgets($category->idx, 'post-view', 'postViewWidget'); ?>
                </td>
            </tr>




            <tr>
                <td><?= ek('Forum List Header', '글 목록 헤더 위젯') ?></td>
                <td>
                    <?php select_list_widgets($category->idx, 'post-list-header', 'postListHeaderWidget'); ?>
                </td>
            </tr>



            <tr>
                <td><?= ek('Forum List Widget', '글 목록 위젯') ?></td>
                <td>
                    <?php select_list_widgets($category->idx, 'post-list', 'postListWidget'); ?>
                </td>
            </tr>


            <tr>
                <td><?= ek('Forum List Pagination Widget', '네비게이션 위젯') ?></td>
                <td>
                    <?php
                    select_list_widgets($category->idx, 'pagination', 'paginationWidget');
                    ?>
                </td>
            </tr>






            <tr>
                <td><?= ek('Post list under view page', '글 읽기 아래 목록') ?></td>
                <td>
                    <label>
                        <input data-cy="form-list-on-view-Y" type="radio" name="listOnView" value="Y" <?php if ($category->listOnView == 'Y') echo 'checked' ?>> <?= ek('Yes', '예') ?>,
                    </label>
                    &nbsp;
                    <label>
                        <input data-cy="form-list-on-view-N" type="radio" name="listOnView" value="N" <?php if ($category->listOnView != 'Y') echo 'checked' ?>> <?= ek('No', '아니오') ?>
                    </label>
                </td>
            </tr>
            <tr>
                <td><?= ek('No of posts per page', '페이지 글 수') ?></td>
                <td>
                    <input data-cy="form-post-per-page" class="form-control" name="noOfPostsPerPage" type="text" value="<?= $category->noOfPostsPerPage ?>">
                </td>
            </tr>
            <tr>
                <td nowrap><?= ek('No of pages on navigator', '네이게이션 페이지 수') ?></td>
                <td>
                    <input data-cy="form-pages-on-nav" class="form-control" name="noOfPagesOnNav" type="text" value="<?= $category->noOfPagesOnNav ?>">
                </td>
            </tr>


            <tr class="table-dark">
                <td colspan="2"><?= ek('App Widgets', '앱 위젯 설정') ?></td>
            </tr>

            <tr>
                <td><?= ek('Post List Widget', '글 목록 위젯') ?></td>
                <td>
                    <label class="">
                        <input data-cy="form-mobile-post-list-text" type="radio" name="mobilePostListWidget" value="text" <?php if ($category->mobilePostListWidget == 'text') echo 'checked' ?>> <?= ek('Text', '텍스트') ?>
                    </label>
                    <label class="ps-2">
                        <input data-cy="form-mobile-post-list-gallery" type="radio" name="mobilePostListWidget" value="gallery" <?php if ($category->mobilePostListWidget == 'gallery') echo 'checked' ?>> <?= ek('Gallery', '갤러리') ?>
                    </label>

                    <label class="ps-2">
                        <input data-cy="form-mobile-post-list-thumbnail" type="radio" name="mobilePostListWidget" value="thumbnail" <?php if ($category->mobilePostListWidget == 'thumbnail') echo 'checked' ?>> <?= ek('Thumbnail', '썸네일') ?>
                    </label>

                </td>
            </tr>

            <tr>
                <td><?= ln(['en' => 'Post View Widget', 'ko' => '글 읽기 위젯']) ?></td>
                <td>
                    <label class="">
                        <input data-cy="form-mobile-post-view-default" type="radio" name="mobilePostViewWidget" value="default" <?php if ($category->mobilePostViewWidget == 'default') echo 'checked' ?>> <?= ek('Default', '기본') ?>
                    </label>
                    <label class="ps-2">
                        <input data-cy="form-mobile-post-view-slide" type="radio" name="mobilePostViewWidget" value="slide" <?php if ($category->mobilePostViewWidget == 'slide') echo 'checked' ?>> <?= ek('Slide', '슬라이드') ?>
                    </label>

                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <button class="btn btn-sm btn-success w-100" data-cy="form-submit" type="submit">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>


</form>