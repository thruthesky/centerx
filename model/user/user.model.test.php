<?php

$ut = new UserModelTest();
$ut->update();
$ut->blockUserFields();



class UserModelTest
{
    public function update() {
        $user = registerAndLogin();
        $user->update(['name' => 'yo']);
        isTrue($user->name == 'yo', 'User name is yo');
    }

    public function blockUserFields() {
        // 사용자 이름 변경하지 못하도록 막는다.
        config()->blockUserFields = [ 'name' ];

        // 사용자 이름 업데이트 테스트.
        $user = registerAndLogin();
        $user->update(['name' => 'yo']);

        // 결과: 이름 변경하지 못하도록 막았으므로, 에러.
        isTrue($user->hasError && $user->getError() == e()->block_user_field, 'user name update is blocked');
        isTrue($user->getErrorInfo() == 'name', 'user name update is blocked');
        isTrue($user->name != 'yo', 'User name must not be yo');
    }
}