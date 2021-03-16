<?php

$category = category(in(CATEGORY_ID));

if ( $category->exists() == false ) jsBack("게시판 카테고리가 존재하지 않습니다.");



$categoryId = in(CATEGORY_ID);
$limit = 10;
$where = "parentIdx=0 AND categoryId=<$categoryId>";
$posts = post()->search(where: $where, page: in('page', 1), limit: $limit);
$total = post()->count($where);



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


