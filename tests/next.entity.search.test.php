<?php

_testUserSearch();
_testEntitySearch();
_testEntityMy();

function _testUserSearch() {
    $pw = '12345a' . time();
    $emailA = 'userA' . time() . '@test.com';
    $emailB = 'userB' . time() . '@test.com';
    $emailC = 'userC' . time() . '@test.com';

    $a = user()->create([EMAIL => $emailA, PASSWORD=>$pw]);
    $b = user()->create([EMAIL => $emailB, PASSWORD=>$pw]);
    $c = user()->create([EMAIL => $emailC, PASSWORD=>$pw]);


    $users = user()->search(limit: 3, object: false);
    isTrue($users[0][IDX] == $c->idx, "object: false, C idx: {$c->idx} match! C is the last one.");

    $users = user()->search(limit: 3);
    isTrue($users[0]->idx == $c->idx, "object: true, A idx: {$c->idx} match! C is the last one.");

    $users = user()->search(where: "email LIKE 'user%'", object: false);
    isTrue( count($users) >= 3, "There are more than 3 users");
    isTrue(gettype($users[0]) == 'array', 'Default search is array');

    $users = user()->search(where: "email LIKE 'user%'");
    isTrue($users[0] instanceof User, "instanceof => User object");
    isTrue(get_class($users[0]) == 'User',"get_class() => User object");



}

function _testEntitySearch() {

    $title = 'here ' . time();

    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);
    $here = entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345, 'title'=>$title]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);

    $re = entity(POSTS)->search('userIdx=12345');
    isTrue(count($re) >= 4);

    $arr = entity(POSTS)->search(conds: ['title' => $title]);
    isTrue(count($arr) == 1);
    $idx = $arr[0]['idx'];

    isTrue(entity(POSTS, $idx)->title == $title);

}


function _testEntityMy() {

    $email = 'my'.time().'@email.com';
    $user = entity(USERS)->create(['email' => $email, 'password' => '12345a']);

    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => $user->idx]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => $user->idx]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => $user->idx]);

    setLogin($user->idx);
    $re = entity(POSTS)->my();
    isTrue(count($re) == 3);
}