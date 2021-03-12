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
$post = post($p1[IDX]);
$c1 = comment()->create([ROOT_IDX => $post->idx, PARENT_IDX => $post->idx, CONTENT => 'hi']);


// 코멘트에 Y 추천
$votedComment = comment($c1[IDX])->vote('Y');
isTrue($votedComment['Y'] == 1);

// 동일한 코멘트에 N 추천.
$votedComment = comment($c1[IDX])->vote('N');
isTrue($votedComment['Y'] == 0);
isTrue($votedComment['N'] == 1);


// 글에 N 추천. 이 때, postTaxonomy() 를 사용.
$votedPost = postTaxonomy($p1[IDX])->vote('N');
isTrue($votedPost['N'] == 1, 'N must be 1');

// 동일한 글에 N 한번 더 추천
$votedPost = post($p1[IDX])->vote('N');
isTrue($votedPost['N'] == 0, 'N must be 0');




