<?php

if ( in(CATEGORY_ID) ) {
    $category = category(in(CATEGORY_ID));
} else {
    $category = category( postCategoryIdx(in(IDX)) );
}


if ( $category->exists() == false ) jsBack("게시판 카테고리가 존재하지 않습니다.");


include_once widget( $category->postEditWidget ?? 'post-edit/post-edit-default' );

