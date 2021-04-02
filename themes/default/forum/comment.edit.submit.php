<?php

$comment;
if (in(IDX)) {
    $comment = comment(in(IDX))->update(in());
} else {
    $comment = comment()->create(in());
}

if ($comment->hasError) jsBack($comment->getError());


$category = $comment->category();
$category->returnToAfterPostEdit;

if ($category->returnToAfterPostEdit == 'L') {
    jsGo("/?p=forum.post.list&categoryId=" . $comment->categoryId());
} else {
    jsGo($comment->post()->url);
}
