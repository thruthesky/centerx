<?php


$comment = comment()->create(in());
if ( $comment->hasError ) jsBack($comment->getError());
if ( in('returnTo') == 'post' ) {
    jsGo($comment->post()->url); // post($comment[ROOT_IDX])->get()['url']);
} else {
    jsGo("/?p=forum.post.list&categoryId=" . $comment->categoryId() );
}
