<?php

if ( modeSubmit() ) {
    foreach( DEFAULT_CATEGORIES as $categoryId ) {
        $category = category($categoryId);
        if ( $category->exists() == false ) {
            $re = category()->create([ID => $categoryId]);
        }
    }
} else if ( in('mode') == 'create-posts' ) {
    d("글 100개를 생성합니다.");
    foreach( COMMUNITY_CATEGORIES as $cat ) {
        for($i=0; $i<20; $i++) {
            post()->create([CATEGORY_ID => $cat, TITLE=>"$cat 카테고리: $i 번째 글.", CONTENT=>"글 내용입니다.\n$cat 카테고리의 $i 번째 글입니다."]);
        }
    }
}

foreach( DEFAULT_CATEGORIES as $categoryId ) {
    $category = category($categoryId);
    if ( $category->exists() ) echo "<div class='fs-title'>{$category->title}</div><div class='fs-desc'>$categoryId</div><hr>";
    else echo "<div class='alert alert-danger'>$categoryId 가 존재하지 않습니다.</div><hr>";
}

?>
<a href="/?admin.index&mode=submit">존재하지 않는 게시판 생성하기</a> |
<a href="/?admin.index&mode=create-posts">커뮤니티 게시판에 글 20개 생성하기</a>
