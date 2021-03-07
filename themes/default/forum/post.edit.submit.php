<?php
if ( in(IDX) ) {
    $post = post(in(IDX))->update(in());
    $categoryId = post(in(IDX))->categoryIdx();
}
else {
    $post = post()->create(in());
    $categoryId = in(CATEGORY_ID);
}

if ( isError($post) ) jsBack($post);


if ( in('returnTo') == 'post' ) {
    jsGo($post['url']);
} else {
    jsGo("/?p=forum.post.list&categoryId=" . in(CATEGORY_ID) );
}



