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
    $url = "/?p=forum.post.list&categoryId=" . $categoryId;
    if ( in('lsub') ) $url .= lsub();
    jsGo($url);
} else {
    $url = $post->url;
    if ( in('lsub') ) $url .= lsub(true);
    jsGo($url);
}



