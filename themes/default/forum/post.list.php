<?php

$category = category(in(CATEGORY_ID) ? in(CATEGORY_ID) : 0);

if ($category->hasError && $category->getError() == e()->entity_not_found) {
    jsAlert('카테고리가 존재하지 않습니다.');
}


list( $where, $params ) = parsePostListHttpParams(in());


$posts = post()->search(where: $where, params: $params, page: in('page', 1), limit: in('limit', 10), object: true);
$total = post()->count(where: $where, params: $params);


if ( isset($in['searchKey']) ) saveSearchKeyword($in['searchKey']);


hook()->run('post-list-top');

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
    'limit' => in('limit', 10),
    'blocks' => 3,
    'arrow' => true,
    'total' => $total,
    'no_of_posts_per_page' => $category->v('noOfPagesOnNav', 10),
    'url' => $url,
]);
