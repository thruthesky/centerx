<?php


insertMetaTest();
checkMetaTest();
getMetaTest();
updateMetaTest();
deleteMetaTest();


function insertMetaTest() {

    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code' . time();
    $data = 'data' . time();

    $re = meta()->create([ TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($re == '', "should be success");
    $re = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data]);
    isTrue($re == '', "should be success");

}

function checkMetaTest() {

}


function getMetaTest() {

    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $entityThree = 3;
    $code = 'code' . time();
    $data = 'data' . time();

    $re = meta()->create([ TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($re == '', "should be success");
    $re = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data]);
    isTrue($re == '', "should be success");

    $re = meta()->get($taxonomy, $entityOne);
    isTrue(count($re) > 0, "data must exist");
    isTrue($re[$code] == $data, "code data should exist");

    $re = meta()->get($taxonomy, $entityTwo);
    isTrue(count($re) > 0, "data must exist");
    isTrue($re[$code] == $data, "code data should exist");

    $re = meta()->get($taxonomy, $entityThree);
    isTrue(!isset($re[$code]), "code data should not exist entity 3");


    $re = meta()->get($taxonomy, $entityOne, $code);
    isTrue($re['data'] == $data, "data should exist");
    $re = meta()->get($taxonomy, $entityTwo, $code);
    isTrue($re['data'] == $data, "data should exist");

    $re = meta()->get($taxonomy, $entityThree, $code);
    isTrue($re == null, "data should exist");

    $re = meta()->get($taxonomy, $entityOne, $code . 1 );
    isTrue($re == null , "code should not exist");
    $re = meta()->get($taxonomy, $entityTwo, $code . 1 );
    isTrue($re == null , "code should not exist");
}
function updateMetaTest() {


    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code' . time();
    $data = 'data' . time();

    $re = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($re == '', "updateMetaTest addMeta should be success");
    $re = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data]);
    isTrue($re == '', "updateMetaTest addMeta should be success");

    $re = meta()->update([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data . 'updated']);
    isTrue($re == '', "updateMetaTest updateMeta should be success");
    $re = meta()->update([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data . 'updatedForTwo']);
    isTrue($re == '', "updateMetaTest updateMeta should be success");

    $re = meta()->get($taxonomy, $entityOne, $code);
    isTrue($re['data'] == $data . "updated", "updateMetaTest data should exist and updated");
    $re = meta()->get($taxonomy, $entityTwo, $code);
    isTrue($re['data'] == $data . "updatedForTwo", "updateMetaTest data should exist and updated");


    $re = meta()->get($taxonomy, $entityOne);
    isTrue(count($re) > 0, "data must exist");
    isTrue($re[$code] == $data . "updated", "code data should exist");
    $re = meta()->get($taxonomy, $entityTwo);
    isTrue(count($re) > 0, "data must exist");
    isTrue($re[$code] == $data . "updatedForTwo", "code data should exist");

}

function deleteMetaTest() {

}

