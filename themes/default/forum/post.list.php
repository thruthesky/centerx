<?php

$category = category(in(CATEGORY_ID) ? in(CATEGORY_ID) : 0);

if ($category->hasError && $category->getError() == e()->entity_not_found) {
    jsAlert('카테고리가 존재하지 않습니다.');
}


list( $where, $params ) = parsePostListHttpParams(in());


// 글 목록 추출
$posts = post()->search(where: $where, params: $params, page: in('page', 1), limit: in('limit', 10), object: true);

// 글 총(전체) 개수
$total = post()->count(where: $where, params: $params);

// 공지사항 추출
$reminders = category(in(CATEGORY_ID))->reminders(in());


if ( isset($in['searchKey']) ) saveSearchKeyword($in['searchKey']);



// Hook for the very top of the post list page.
hook()->run(HOOK_POST_LIST_TOP);

// For post list widget, it will first include 'post-list-top.php' script if exists.

$post_list_path = $category->postListWidget ? $category->postListWidget : 'post-list/post-list-default';
$post_list_top_path = str_replace('.php', '.top.php', get_widget_script_path($post_list_path));
if ( file_exists($post_list_top_path) ) include_once $post_list_top_path;

$post_list_header_path = $category->postListHeaderWidget ? $category->postListHeaderWidget : 'post-list-header/post-list-header-default';
include_once widget($post_list_header_path, [
    'category' => $category,
]);


include_once widget($post_list_path, [
    'category' => $category,
    'reminders' => $reminders,
    'posts' => $posts,
    'total' => $total,
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
