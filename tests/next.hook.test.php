<?php
setLoginAny();


hook()->add('posts-before-create', function(&$record, $in) {
    $record['title'] = ($record['title'] ?? '') . ' hook called';
});


// 테스트 카테고리 존재하지 않으면 생성,
$category = category('test');
if ( $category->exists() == false ) {
    category()->create([ID => 'test']);
    $category = category('test');
}



// 글 생성
$p1 = post()->create([ CATEGORY_ID => 'test', 'title' => 'yo' ]);

isTrue($p1->title == 'yo hook called');


// 코멘트 생성
$c1 = comment()->create([ROOT_IDX => $p1->idx, PARENT_IDX => $p1->idx, CONTENT => 'hi']);
isTrue( $c1->title == ' hook called', 'hook called on coment');


hook()->delete('posts-before-create');