<?php

if ( in(CATEGORY_ID) ) {
    $category = category(in(CATEGORY_ID));
} else if ( in(IDX) ) {
    $category = category( post(in(IDX))->categoryIdx() );
}

if ( $category->exists() == false ) jsBack("게시판 카테고리가 존재하지 않습니다.");


include_once widget( $category->v('postEditWidget', 'post-edit/post-edit-default') );

