<?php


$post = post(in(IDX))->permissionCheck()->markDelete();

if ( $post->hasError ) jsBack($post->getError());
jsGo("/?p=forum.post.list&categoryId=" . $post->categoryId() );


