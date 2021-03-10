<?php

_testEntitySearch();
_testEntityMy();

function _testEntitySearch() {


    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);
    entity(POSTS)->create([CATEGORY_IDX => 1, USER_IDX => 12345]);

    $re = entity(POSTS)->search('userIdx=12345');
    isTrue(count($re) >= 4);

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