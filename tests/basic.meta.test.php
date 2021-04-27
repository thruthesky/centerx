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

    $record = [ TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data];
    $m = meta()->create($record);
    isTrue($m->idx > 0, "Creating a meta: " . json_encode($record));
    $m2 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data]);
    isTrue($m2->idx > 0, "should be success");

}

function checkMetaTest() {
    $code = 'a.' . time();
    isTrue(meta()->create([TAXONOMY => 'test', ENTITY => 1, CODE => $code, DATA => 'apple'])->exists, "Meta a must exists");
    isTrue(meta()->exists == false, "Meta must not exists with empty container");
    isTrue(meta()->exists([CODE => $code]), "Meta code $code must exist!");
    isTrue(meta()->exists([TAXONOMY => 'test', ENTITY => 1, CODE => $code]), "Meta exists with test.1.$code");
    isTrue(meta()->exists([CODE => 'adjlfajldfladlfasdfl']) == false, "Meta must not exist with non-existing code");

}


function getMetaTest() {

    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $entityThree = 3;
    $code = 'code-1' . time();
    $data = 'data' . time();

    $m1 = meta()->create([ TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($m1->idx > 0, "m1 should be success");
    $m2 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data]);
    isTrue($m2->idx > 0 && $m2->exists, "m2 should be success");


    $re = meta()->get($taxonomy, $entityOne);
    isTrue(count($re) > 0, "The data of $taxonomy and $entityOne must exist");
    isTrue($re[$code] == $data, "code data should exist");

    $re = meta()->get($taxonomy, $entityTwo);
    isTrue(count($re) > 0, "The data of entityTwo must exist");
    isTrue($re[$code] == $data, "The data of entityTwo must match.");


    $re = meta()->get($taxonomy, $entityThree);
    isTrue($re == null, "entityTree must not exists. It's non-existent.");


    $re = meta()->get($taxonomy, $entityOne, $code);
    isTrue($re['data'] == $data, "Data test of entityOne");
    $re = meta()->get($taxonomy, $entityTwo, $code);
    isTrue($re['data'] == $data, "Data test of entityTwo");

    $re = meta()->get($taxonomy, $entityThree, $code);
    isTrue($re == null, "No record found by the code - entityTree");

    $re = meta()->get($taxonomy, $entityOne, $code . 1 );
    isTrue($re == null , "Non-existence test - with entityOne + code1");

    $re = meta()->get($taxonomy, $entityTwo, $code . 1 );
    isTrue($re == null , "Non-existence test - with entityTwo + code1");
}
function updateMetaTest() {


    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-update' . time();
    $data = 'data' . time();

    $m1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($m1->idx > 0, "create code: entityOne + $code");
    $m2 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code, DATA => $data]);
    isTrue($m2->idx > 0, "create code: entityTwo + $code");

    $m1Up = meta()->update([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data . 'updated']);
    isTrue($m1Up->idx == $m1->idx && $m1Up->data == $data . 'updated', "Update - entityOne: " . $m1Up->getError());


    /// update with new code & taxonomy, entity
    $m2->update([TAXONOMY => 'tax', ENTITY => 88, CODE => $code . 'yo', DATA => 'ye']);


    isTrue($m2->getData(TAXONOMY) == 'tax' && $m2->entity == 88 &&
        $m2->code == $code . 'yo' && $m2->data == 'ye', "m2 updated.");

}

function deleteMetaTest() {

}

