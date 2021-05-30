<?php

include 'user.controller.php';

$userController = new UserController();


$re = $userController->register([]);
isTrue($re == e()->email_is_empty, 'Email is empty');

$stamp = time();

$re = $userController->register([
    EMAIL => "user.con$stamp@email.com",
    PASSWORD => 'pw' . $stamp
]);


isTrue($re[IDX], 'Register success on controller.');

