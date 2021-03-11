<?php

setLogout();

testPostEntity();
testPostCreate();
testPostRead();
testPostUpdate();
testPostDelete();
testPostResponse();


function testPostEntity() {
    isTrue( get_class(post()) == 'Post', 'is post');
}
function testPostCreate() {

    // 카테고리 empty
    setLoginAny();
    $errstr = post()->create([])->getError();
    isTrue($errstr == e()->category_id_is_empty, 'expect: category_id_is_empty but got: ' . $errstr);

    // 카테고리 존재하지 않음
    isTrue(post()->create(['categoryId' => 'apple'])->getError() == e()->category_not_exists, '');

    $cat = category()->create(['id' => 'apple' . time()]);


    $p = post()->create(['categoryId' => $cat->id]);
    isTrue($p->hasError == false, 'no error');
    isTrue($p->categoryIdx == post($p->idx)->categoryIdx, 'category idx match');
}
function testPostRead() {

    $title = 'read-test-' . time();
    $cat = category()->create(['id' => 'read' . time()]);
    $p = post()->create(['categoryId' => $cat->id, 'title' => $title]);
    $read1 = post($p->idx);

    // 두번 째 글 생성
    $p = post()->create(['categoryId' => $cat->id, 'title' => $title]);
    $read2 = post($p->idx);

    // path 가 달라야 함.
    isTrue($read1->path != $read2->path, 'path test but got: ' . $read2->path);

    // URL 테스트
    isTrue( $read2->url == get_current_root_url() . $read2->path, 'url test' );

}
function testPostUpdate() {
    $cat = category()->create(['id' => 'update' . time()]);
    $p = post()->create(['categoryId' => $cat->id]);
    isTrue($p->update(['title' => 'yo'])->title == 'yo', 'update yo');
}

function testPostDelete() {
    $cat = category()->create(['id' => 'delete' . time()]);
    $p = post()->create(['categoryId' => $cat->id]);
    isTrue($p->delete()->getError() == e()->post_delete_not_supported, 'post cannot be deleted');
    isTrue($p->markDelete()->getError() == e()->not_your_post, 'not your post');
    isTrue(post($p->idx)->markDelete()->deletedAt > 0, 'deleted');
    isTrue(post($p->idx)->markDelete()->getError() == e()->entity_deleted_already, 'deleted already');
}

function testPostResponse() {
    $cat = category()->create(['id' => 'response' . time()]);
    $res = post()->create(['categoryId' => $cat->id, 'title' => 'yo'])->response();
    isTrue(is_array($res), 'response is array');
    isTrue($res['idx'] > 0, 'response idx is bigger than 0');
}