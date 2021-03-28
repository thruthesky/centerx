<?php

$category = category(in(CATEGORY_ID) ? in(CATEGORY_ID) : 0);

if ( $category->hasError && $category->getError() == e()->entity_not_found ) {
    jsAlert('카테고리가 존재하지 않습니다.');
}


$limit = 10;
$conds = [PARENT_IDX => 0];
if ( $category->exists() ) $conds[CATEGORY_IDX] = $category->idx;
$posts = post()->search(page: in('page', 1), limit: $limit, conds: $conds);
$total = post()->count(conds: $conds);




include theme()->part('post-list-top');
include_once widget( $category->postListHeaderWidget ? $category->postListHeaderWidget : 'post-list-header/post-list-header-default' );


include_once widget( $category->postListWidget ? $category->postListWidget : 'post-list/post-list-default', [
    'posts' => $posts,
] );


include_once widget( $category->paginationWidget ? $category->paginationWidget : 'pagination/pagination-default', [
    'page' => in('page', 1),
    'limit' => $limit,
    'blocks' => 3,
    'arrow' => true,
    'total' => $total,
    'no_of_posts_per_page' => $category->v('noOfPagesOnNav', 10),
    'url' => '/?p=forum.post.list&categoryId=' . in(CATEGORY_ID) . '&page={page}',
]);


