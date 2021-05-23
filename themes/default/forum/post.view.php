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

include_once widget($post->category()->postViewWidget ? $post->category()->postViewWidget : 'post-view/post-view-default');

