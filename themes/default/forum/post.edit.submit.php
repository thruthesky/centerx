<?php
if ( in(IDX) ) {
    $post = post(in(IDX))->update(in());
    $categoryId = postCategoryId($post->idx);
}
else {
    $post = post()->create(in());
    $categoryId = in(CATEGORY_ID);
}

if ( $post->hasError ) jsBack($post->getError());


if ( in('returnTo') == 'post' ) {
    d($post);
//    jsGo($post->url);
} else {
    jsGo("/?p=forum.post.list&categoryId=" . $categoryId );
}



