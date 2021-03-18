<?php


$comment = comment()->create(in());
if ( $comment->hasError ) jsBack($comment->getError());


$category = $comment->category();
$category->returnToAfterPostEdit;

if ( $category->returnToAfterPostEdit == 'L' ) {
    jsGo("/?p=forum.post.list&categoryId=" . $comment->categoryId() );
} else {
    jsGo($comment->post()->url);
}
