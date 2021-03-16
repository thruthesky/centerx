<?php
/**
 * @file view.php
 */
/**
 * Get the post
 */

$post = post()->current();

if ( $post == null ) {
    $_uri = urldecode($_SERVER['REQUEST_URI']);
    return displayWarning("접속 경로 '$_uri' 에 해당하는 글이 없습니다.");
}


/**
 * Get the category of the post
 */

//run_hook('forum_category', $category);
//$o = [
//    'category' => $category,
//];

$w = $post->category()->v('postViewWidget', 'post-view/post-view-default');
include_once widget($w);

