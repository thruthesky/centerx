<?php

setLoginAny();

// 테스트 카테고리 존재하지 않으면 생성,
$category = category('test');
if ( $category->exists() == false ) {
    category()->create([ID => 'test']);
    $category = category('test');
}



// 글 생성
$p1 = post()->create([ CATEGORY_ID => 'test', 'title' => 'yo' ]);



// 코멘트 생성
$c1 = comment()->create([ROOT_IDX => $p1->idx, PARENT_IDX => $p1->idx, CONTENT => 'hi']);



// 코멘트에 Y 추천
$votedComment = $c1->vote('Y');
isTrue(get_class($votedComment) == 'CommentModel', 'vote returns Comment');
//isTrue($votedComment->Y == 1);

//// 동일한 코멘트에 N 추천.
//$votedComment = $c1->vote('N');
//isTrue($votedComment->Y == 0);
//isTrue($votedComment->N == 1);
//
//
//// 글에 N 추천. 이 때, postTaxonomy() 를 사용.
//$votedPost = postTaxonomy($p1->idx)->vote('N');
//isTrue($votedPost->N == 1, 'N must be 1');
//
//// 동일한 글에 N 한번 더 추천
//$votedPost = $p1->vote('N');
//isTrue($votedPost->N == 0, 'N must be 0');




