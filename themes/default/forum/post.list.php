<?php

$category = category(in(CATEGORY_ID) ? in(CATEGORY_ID) : 0);

if ($category->hasError && $category->getError() == e()->entity_not_found) {
    jsAlert('카테고리가 존재하지 않습니다.');
}




$limit = 10;
$params = [];

$where = "parentIdx=0 AND deletedAt=0";
//$conds = [PARENT_IDX => 0, DELETED_AT => 0];

if ($category->exists()) {
    $where .= " AND categoryIdx=" . $category->idx;
}

if (in('subcategory')) {
    $where .= " AND subcategory=?";
    $params[] = in('subcategory');
}

/**
 * 국가 코드
 * README 참고
 */
$countryCode = in('countryCode');
hook()->run('post_list_country_code', $countryCode);
if ( $countryCode ) {
    $where .= " AND countryCode=?";
    $params[] = $countryCode;
}

if ( in('searchKey') ) {
    $where .= " AND (title LIKE ? OR content LIKE ?) ";
    $params[] = '%' . in('searchKey') . '%';
    $params[] = '%' . in('searchKey') . '%';
}

if ( in('userIdx') && is_numeric(in('userIdx')) ) {
    $where .= " AND userIdx=? ";
    $params[] = in('userIdx');
}



$posts = post()->search(where: $where, params: $params, page: in('page', 1), limit: $limit, object: true);
$total = post()->count(where: $where, params: $params);


include theme()->part('post-list-top');
include_once widget($category->postListHeaderWidget ? $category->postListHeaderWidget : 'post-list-header/post-list-header-default', [
    'category' => $category,
]);


include_once widget($category->postListWidget ? $category->postListWidget : 'post-list/post-list-default', [
    'posts' => $posts,
    'total' => $total,
    'category' => $category,
]);


$url = '/?p=forum.post.list&categoryId=' . in(CATEGORY_ID);
$url .= "&page={page}";
include_once widget($category->paginationWidget ? $category->paginationWidget : 'pagination/pagination-default', [
    'page' => in('page', 1),
    'limit' => $limit,
    'blocks' => 3,
    'arrow' => true,
    'total' => $total,
    'no_of_posts_per_page' => $category->v('noOfPagesOnNav', 10),
    'url' => $url,
]);
