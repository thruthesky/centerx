<?php


$comment = comment()->create(in());
if ( isError($comment) ) jsBack($comment);
if ( in('returnTo') == 'post' ) {
    jsGo(post($comment[ROOT_IDX])->get()['url']);
} else {
    jsGo("/?p=forum.post.list&categoryId=" . comment($comment)->categoryId() );
}
