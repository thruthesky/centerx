<?php

setLogout();

testPostEntity();
testPostCreate();
testPostRead();
testPostUpdate();
testPostDelete();
testPostResponse();


function testPostEntity() {
    isTrue( get_class(post()) == 'PostTaxonomy', 'is post');
}

function testPostCreate() {

    // error: empty category
    setLoginAny();
    $errstr = post()->create([])->getError();
    isTrue($errstr == e()->category_id_is_empty, 'expect: category_id_is_empty but got: ' . $errstr);


    // error: non-existent category. 카테고리 존재하지 않음
    isTrue(post()->create(['categoryId' => 'apple'])->getError() == e()->category_not_exists, '');

    // success
    $cat = category()->create(['id' => 'apple' . time()]); // create a category.
    $p = post()->create(['categoryId' => $cat->id]); // create a post.

    isTrue($p->ok, 'no error');
    isTrue($p->categoryIdx == post($p->idx)->categoryIdx, 'category idx match');
    isTrue($p->Ymd == date('Ymd'), 'Ymd check');
}

function testPostRead() {

    // title
    $title = 'read-test-' . time();

    // create a category
    $cat = category()->create(['id' => 'read' . time()]);

    // create a post
    $p = post()->create(['categoryId' => $cat->id, 'title' => $title]);

    // read
    $read1 = post($p->idx);

    // create second post with same category and same title, then read
    $p = post()->create(['categoryId' => $cat->id, 'title' => $title]);
    $read2 = post($p->idx);

    // the two posts must have different path!
    isTrue($read1->path != $read2->path, 'path test but got: ' . $read2->path);

    // url test
    isTrue( $read2->url == get_current_root_url() . $read2->path, 'url test' );


}

function testPostUpdate() {
    $cat = category()->create(['id' => 'update' . time()]);
    $p = post()->create(['categoryId' => $cat->id]);
    isTrue($p->update(['title' => 'yo'])->title == 'yo', 'update yo');

    isTrue( post()->create([CATEGORY_ID => $cat->id, TITLE => 'title'])->update([TITLE => 'up'])->title == 'up', 'Title is up');
}


function testPostDelete() {
    setLogin1stUser(); // login 1st user
    $cat = category()->create(['id' => 'delete' . time()]); // create category
    $p = post()->create(['categoryId' => $cat->id]); // create post
    isTrue($p->delete()->getError() == e()->post_delete_not_supported, 'post cannot be deleted'); // post delete failed.


    setLogin2ndUser(); // login 2nd user.
    $p1 = post($p->idx); // get the post that 1st user wrote.
    isTrue($p1->permissionCheck()->getError() == e()->not_your_entity, "permissionCheck() error == not your entity");
    isTrue($p1->permissionCheck()->markDelete()->getError() == e()->not_your_entity, "testPostDelete() => not_your_entity");

    setLogin1stUser();
    isTrue(post($p->idx)->permissionCheck()->ok, "permission ok for 1st user to delete");
    isTrue(post($p->idx)->permissionCheck()->markDelete()->deletedAt > 0, 'deleted');
    isTrue(post($p->idx)->permissionCheck()->markDelete()->getError() == e()->entity_deleted_already, 'deleted already');
}

function testPostResponse() {
    $cat = category()->create(['id' => 'response' . time()]); // create a category
    $res = post()->create(['categoryId' => $cat->id, 'title' => 'yo'])->response(); // create a post and get response
    isTrue(is_array($res), 'response is array');
    isTrue($res['idx'] > 0, 'response idx is bigger than 0');
}