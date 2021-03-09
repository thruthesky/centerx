<?php


setLoginAny();

$category = category('test');
if ( $category->exists() == false ) {
    category()->create([ID => 'test']);
    $category = category('test');
}



$p1 = post()->create([ CATEGORY_ID => 'test', 'title' => 'yo' ]);




$post = post($p1[IDX]);
$c1 = comment()->create([ROOT_IDX => $post->idx, PARENT_IDX => $post->idx, CONTENT => 'hi']);
$votedComment = comment($c1[IDX])->vote('Y');
isTrue($votedComment['Y'] == 1);

$votedComment = comment($c1[IDX])->vote('N');
isTrue($votedComment['Y'] == 0);
isTrue($votedComment['N'] == 1);






$votedPost = postTaxonomy($p1[IDX])->vote('N');
isTrue($votedPost['N'] == 1, 'N must be 1');

$votedPost = postTaxonomy($p1[IDX])->vote('N');
isTrue($votedPost['N'] == 0, 'N must be 0');




