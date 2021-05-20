<?php


$post = post(in(IDX))->markDelete();

if ( $post->hasError ) jsBack($post->getError());
jsGo( postListUrl( $post->categoryId() ) );


