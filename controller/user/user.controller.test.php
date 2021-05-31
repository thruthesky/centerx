<?php

include 'user.controller.php';

$userController = new UserController();


$re = $userController->register([]);
isTrue($re == e()->email_is_empty, 'Email is empty');

$stamp = time();

$re = $userController->profile([]);
isTrue($re = e()->not_logged_in, 'user not logged in.');

$re = $userController->register([
    EMAIL => "user.con$stamp@email.com",
    PASSWORD => 'pw' . $stamp
]);
isTrue($re[IDX], 'Register success on controller.');



registerAndLogin();
$re = $userController->profile([]);
isTrue($re[IDX], 'register, login, profile');


$admin = setLoginAsAdmin();
isTrue(admin(), "admin() => The user is admin");

