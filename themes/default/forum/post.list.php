<?php

$category = category(in(CATEGORY_ID));

if ( $category->exists() == false ) jsBack("게시판 카테고리가 존재하지 않습니다.");

include_once widget( $category->v('postListHeaderWidget', 'post-list-header/post-list-header-default') );
include_once widget( $category->v('postListWidget', 'post-list/post-list-default') );




include_once widget( $category->v('paginationWidget', 'pagination/pagination-default'), [
    'page' => in('page', 1),
    'blocks' => 3,
    'arrow' => true,
    'total_no_of_posts' => $category->v('noOfPostsPerPage'),
    'no_of_posts_per_page' => $category->v('noOfPagesOnNav'),
    'url' => '/?p=forum.post.list&categoryId=' . in(CATEGORY_ID) . '&page={page}',
]);


