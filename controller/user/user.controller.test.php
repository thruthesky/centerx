<?php

//include 'user.controller.php';
//
//$userController = new UserController();

$re = request('user.register');
isTrue($re == e()->email_is_empty, 'Email is empty');


$re = request('user.profile');
isTrue($re = e()->not_logged_in, 'user not logged in.');

$stamp = time();
$re = request('user.register',[
    EMAIL => "user.con$stamp@email.com",
    PASSWORD => 'pw' . $stamp
]);
isTrue($re[IDX], 'Register success on controller.');


$re = request('user.profile', [SESSION_ID => $re['sessionId']]);
isTrue($re[IDX], 'register, login, profile');


$re = request('user.update', [
    SESSION_ID => $re['sessionId'],
    NAME => "name$stamp",
    NICKNAME => "nick$stamp",
]);
isTrue($re[IDX], 'update name and nickname');


$other = request('user.get', [IDX => $re[IDX]]);
isTrue($other[NAME] == "name$stamp", 'otherUserProfile Expect:: ' . "name$stamp");


$re = request('user.switchOn', [
    SESSION_ID => $re['sessionId'],
    OPTION => "option$stamp",
]);
isTrue($re["option$stamp"] == "Y", "switchOn:: option$stamp on");

$re = request('user.switchOff', [
    SESSION_ID => $re['sessionId'],
    OPTION => "option$stamp",
]);
isTrue($re["option$stamp"] == "N", "switchOn:: option$stamp off");

$re = request('user.switch', [
    SESSION_ID => $re['sessionId'],
    OPTION => "option$stamp",
]);
isTrue($re["option$stamp"] == "Y", "switchOn:: option$stamp on");


$admin = setLoginAsAdmin();
isTrue(admin(), "admin() => The user is admin");