<?php

include 'category.controller.php';

$categoryController = new CategoryController();

$admin = setLoginAsAdmin();


$re = $categoryController->create([]);
isTrue($re == e()->you_are_not_admin, 'not logged in');

$userA = registerAndLogin();
$re = $categoryController->create([]);
isTrue($re == e()->you_are_not_admin, 'not admin');


