<?php


//testEntityTree();
//testEntityCreateWithMeta();
//testEntityErrorHandling();

_testEntityCrud();

_testEntityUpdate();
//_testEntityReadAndReset();
//_testEntityMeta();




class TestTaxonomy extends PostTaxonomy {
    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }
}
function tt($idx=0): TestTaxonomy {
    return new TestTaxonomy($idx);
}

function testEntityErrorHandling() {
    isTrue(tt()->hasError === false, 'no error yet');

    // 에러 유발. 생성된 idx 를 지정하면 에러.
    isTrue(tt()->create(['idx' => 1])->hasError, 'idx must not provided');
    isTrue(tt()->create(['idx' => 1])->getError() == e()->idx_must_not_set, 'idx must not provided');

    isTrue(tt()->create(['idx' => 1])->update(['idx' => 2])->getError() === e()->idx_must_not_set, 'chainging 에서 에러 전달' );
    isTrue(tt()->create(['idx' => 1])->update(['idx' => 2])->read()->getError() == e()->idx_must_not_set, 'chainging 에서 에러 전달' );
    isTrue(tt()->create(['idx' => 1])->update(['idx' => 2])->read()->getData() == [], '에러가 있는 경우, 데이터는 []' );
}

function testEntityCreateWithMeta() {


    $title = 'this is title';
    $in = ['categoryIdx' => 0, 'userIdx' => 0, 'title' => $title, 'color' => 'blue'];


    $tt = tt(0);
    isTrue( $tt->create($in)->title == $title, "title must be $title");
    isTrue( $tt->create($in)->content == '', "content must be ''");
    isTrue( $tt->create($in)->color == 'blue', "color: blue");

    isTrue( $tt->create($in)->update(['content' => 'yo'])->content == 'yo', 'content must be yo');
    isTrue( $tt->create($in)->update(['content' => 'hi'])->markDelete()->deletedAt > 0, 'post is marked as deleted.');
}


function testEntityTree() {

    $tt = tt(0);
    isTrue(get_class($tt), 'TestTaxonomy');


    $created = $tt->create(['categoryIdx' => 0, 'userIdx' => 0, 'title' => 'text taxonomy']);

    isTrue(get_class($created), 'TestTaxonomy');

}




function _testEntityCrud() {

    $pw = '12345a';
    db()->displayError = false;
    // 생성
    $email = 'test'.time().'@email.com';
    $user = entity(USERS)->create(['email' => $email, 'password' => $pw]);
    isTrue($user->hasError === false, 'shoud be success');


    isTrue($user->exists(), 'should be exists');
    isTrue($user->email === $email);

    // 생성 실패. 존재하는 메일 주소.
    isTrue(entity(USERS)->create(['email' => $user->email, 'password' => '12345a'])->getError() === e()->insert_failed, 'fail on re creating with same email');



    // 읽기
    $a = entity(USERS, $user->idx);
    isTrue($a->email === $email, 'user should be readable');

    // 잘못된 사용자 읽기
    $b = entity(USERS, 1234567890);
    isTrue($b->email === null, 'wrong user email');




    $emailA = 'aColorUpdate2'.time().'@email.com';
    // 실패. 존재하는 메일 주소로 업데이트 시도
    // @doc 아래 처럼
    // ->create()->update()->getError()
    // ->create()->update()->delete()->exists()
    // 등과 같이 끝 없이 체이닝을 할 수 있다.
    isTrue(entity(USERS)->create(['email' => '2' . $emailA, 'password' => '12345a'])->update(['email' => $a->email])->getError() === e()->update_failed, 'update failed');

    db()->displayError = true;

    // 삭제
    $emailB = 'b' . time() . '@email.com';

    isTrue(entity(USERS)->create(['email' => $emailB, 'password' => $pw])->update([])->delete()->exists() === false, 'deleted' );

    $deleted = entity(USERS)->create(['email' => $emailB, 'password' => $pw])->update([])->delete();
    isTrue(entity(USERS, $deleted->idx)->getData() === [], 'no more data for deleted user');

}




function _testEntityUpdate() {

    // Update
    $emailA = 'aColorUpdate'.time().'@email.com';
    $created = entity(USERS)->create(['email' => $emailA, 'password' => '12345a']);
    $created->update(['name' => 'newName', 'color' => 'blue']);



    // Expect. Success
    isTrue($created->color === 'blue', 'color must be blue' );

}


function _testEntityReadAndReset() {
    $aEmail = 'a' . time() . '@read.com';
    $bEmail = 'b' . time() . '@read.com';
    $a = entity(USERS)->create(['email' => $aEmail, 'password' => '']);
    $b = entity(USERS)->create(['email' => $bEmail, 'password' => '']);

    $a->update(['eat' => 'apple']);
    isTrue($a->eat === 'apple');

    $b->update(['eat' => 'banana']);
    isTrue($b->eat === 'banana');


    // 주의: $a->reset(3) 을 하면, $a->idx 가 3 으로 변경된다.
    $aIdx = $a->idx;
    isTrue( $a->reset($b->idx)->eat === 'banana', 'reset b' );
    $a->reset($aIdx);
    isTrue( $a->reset($b->idx)->reset($aIdx)->eat === 'apple', 'reset a' );
}

function _testEntityMeta() {

    $email = 'email' . time() . '@email.com';
    $user = entity(USERS)->create(['email' => $email, 'password' => '']);
    isTrue( $user->hasError === false, '_testEntityMeta() test user create');
    $user->update(['eat' => 'apple']);
    isTrue( $user->hasError === false, '_testEntityMeta() test user update');
    isTrue( $user->email === $email, 'user email check');
    isTrue( $user->name === '', 'user name check');
    isTrue( $user->eat === 'apple', 'user eat apple');

    isTrue($user->update(['eat' => 'banana'])->update(['name' => 'yo'])->hasError === false);
    isTrue( $user->name === 'yo', 'user name check');
    isTrue( $user->eat === 'banana', 'user eat apple');
}

