<?php
/**
 * @file view.php
 */
/**
 * Get the post
 */

$post = post()->current();
$post->increaseNoOfViews();

if ( $post->hasError ) {
    if (in('postIdx')) {
        $post = post(in('postIdx'));
    } else {
        $_uri = urldecode($_SERVER['REQUEST_URI']);
        return displayWarning("접속 경로 '$_uri' 에 해당하는 글이 없습니다.");
    }
}

$category = $post->category();
include_once widget($category->postViewWidget ? $category->postViewWidget : 'post-view/post-view-default', ['post' => $post]);


if ( $category->listOnView == 'Y' ) {
    $_REQUEST[CATEGORY_ID] = $post->categoryId();
    include theme()->file('forum.post.list');
}
