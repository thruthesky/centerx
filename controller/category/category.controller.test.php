<?php

include 'category.controller.php';

$categoryController = new CategoryController();

$re = request('category.create');
isTrue($re == e()->you_are_not_admin, 'not logged in');

$admin = setLoginAsAdmin();
$re = $categoryController->create([]);
$re = request('category.create');

$id = 'category-crud' . time();
$cat = request('category.create', [ID=>$id, SESSION_ID=>$admin->sessionId]);
isTrue( $cat[ID] == $id, "Expect: "  . $id);


$getCat = request('category.get', [IDX=>$cat[IDX]]);
isTrue( $cat[IDX] == $getCat[IDX], "Expect: " . $cat[IDX] . " == " . $getCat[IDX]);


$cat = request('category.update', [IDX=>$cat[IDX], TITLE=>'UPDATED-Category', SESSION_ID=>$admin->sessionId]);
isTrue( $cat[TITLE] == 'UPDATED-Category', "Expect: "  . 'UPDATED-Category');


$cat = request('category.delete', [IDX=>$cat[IDX], SESSION_ID=>$admin->sessionId]);


$getCat = request('category.get', [IDX=>$cat[IDX]]);
isTrue( $getCat == e()->entity_not_found, "Expect: " . e()->entity_not_found);

$getsCat = request('category.gets', ['ids' =>$id]);
isTrue( count($getsCat) == 0, 'not found after delete ids string');

$getsCat = request('category.gets', ['ids' =>[$id]]);
isTrue( count($getsCat) == 0, 'not found after delete ids array');
