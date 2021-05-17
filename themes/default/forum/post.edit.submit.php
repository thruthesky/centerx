<?php
if ( in(IDX) ) {
    $post = post(in(IDX))->permissionCheck()->update(in());
    if ( $post->ok ) {
        $categoryId = $post->categoryId();
    }
}
else {
    $post = post()->create(in());
    $categoryId = in(CATEGORY_ID);
}

if ( $post->hasError ) jsBack($post->getError());


$category = category($categoryId);
$category->returnToAfterPostEdit;

if ( $category->returnToAfterPostEdit == 'L' ) {
    $url = "/?p=forum.post.list&categoryId=" . $categoryId;
    jsGo($url);
} else {
    $url = $post->url;
    jsGo($url);
}



