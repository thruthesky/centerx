<?php
if ( in(IDX) ) {
    $post = post(in(IDX))->update(in());
    $categoryId = $post->categoryId();
}
else {
    $post = post()->create(in());
    $categoryId = in(CATEGORY_ID);
}

if ( $post->hasError ) jsBack($post->getError());


$category = category($categoryId);
$category->returnToAfterPostEdit;

if ( $category->returnToAfterPostEdit == 'L' ) {
    jsGo("/?p=forum.post.list&categoryId=" . $categoryId );
} else {
    jsGo($post->url);
}



