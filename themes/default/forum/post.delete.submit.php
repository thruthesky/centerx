<?php


$post = post(in(IDX))->markDelete();

if ( $post->hasError ) jsBack($post->getError());
jsGo("/?p=forum.post.list&categoryId=" . $post->categoryId() );


