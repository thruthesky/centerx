<?php

_testUserSearch();
_testEntitySearch();
_testEntityMy();
_testEntityPrepareStatement();

function _testEntityPrepareStatement() {
    $res = entity(USERS)->search(where: "email LIKE ?", params: ['user%']);
    isTrue(count($res) >= 3, '_testEntityPrepareStatement: count($res) >= 3');
    isTrue($res[0][IDX] > 0, '_testEntityPrepareStatement: $res[IDX] > 0');


    $res = entity(USERS)->search(select: 'idx, email', where: "email LIKE ?", params: ['user%']);
    isTrue($res[0][EMAIL] != '', "_testEntityPrepareStatement: {$res[0][EMAIL]}");



    $res = entity(USERS)->search(select: 'idx, email', where: "idx > ? AND email LIKE ?", params: [2, 'user%'], object: true);
    isTrue($res[0]->email != '', "_testEntityPrepareStatement: {$res[0]->email}");
    isTrue($res[0]->createdAt > 0, "_testEntityPrepareStatement: {$res[0]->createdAt} > 0");
    isTrue($res[0]->idx > 2, 'User idx is bigger than 2');


}



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

    $users = user()->search(limit: 3, object: true);
    isTrue($users[0]->idx == $c->idx, "object: true, A idx: {$c->idx} match! C is the last one.");

    $users = user()->search(where: "email LIKE 'user%'", object: false);
    isTrue( count($users) >= 3, "There are more than 3 users");
    isTrue(gettype($users[0]) == 'array', 'Default search is array');

    $users = user()->search(where: "email LIKE 'user%'", object: true);
    isTrue($users[0] instanceof UserTaxonomy, "instanceof => User object");
    isTrue(get_class($users[0]) == 'UserTaxonomy',"get_class() => User object");



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