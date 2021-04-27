<?php


insertMetaTest();
checkMetaTest();
getMetaTest();
updateMetaTest();
deleteMetaTestViaIdx();
deleteMetaTestViaTaxonomyEntityCode();
deleteMetaTestViaTaxonomyEntity();
deleteMetaTestViaTaxonomyCode();
deleteMetaTestViaEntity();
deleteMetaTestViaCode();
serializeTest();
serializeObjectTest();


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
    isTrue($m1->getData(TAXONOMY) == $taxonomy, "m1 should be success");

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
    isTrue($re == $data, "Data test of entityOne");
    $re = meta()->get($taxonomy, $entityTwo, $code);
    isTrue($re == $data, "Data test of entityTwo");

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

function deleteMetaTestViaIdx()
{
    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-delete-idx' . time();
    $data = 'data' . time();
    $m1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($m1->idx > 0, "create code: entityOne + $code");

    // delete via idx
    $d1 = meta($m1->idx)->delete();
    isTrue($d1->hasError == false, "delete success");
    isTrue($d1->idx > 0, 'deleted remain only on memory.');
    isTrue($d1->idx == $m1->idx, 'idx will be remain only on memory.');
    $find = meta()->findOne([IDX => $m1->idx]);
    isTrue($find->getError() == e()->entity_not_found, 'not found after delete');


    $m1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data]);
    isTrue($m1->idx > 0, "create code: entityOne + $code");


}
function deleteMetaTestViaTaxonomyEntityCode()
{

    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-delete-tec' . time();
    $data = 'data' . time();
    // delete via taxonomy, entity, code
    $d1 = meta()->delete();
    isTrue($d1->hasError, "delete test must fail");
    isTrue($d1->getError() == e()->idx_not_set, "delete fail idx not set");

    $d1 = meta()->delete(taxonomy: $taxonomy);
    isTrue($d1->hasError, "delete test with taxonomy only must fail");
    isTrue($d1->getError() == e()->entity_or_code_not_set, "delete fail entity or code not set");

    $d1 = meta()->delete(taxonomy: $taxonomy, entity: $entityOne, code: $code);
    isTrue($d1->hasError == false, "delete success with taxonomy, entity, code");

}
function deleteMetaTestViaTaxonomyEntity()
{
    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-delete-te' . time();
    $data = 'data' . time();
    // delete via taxonomy and entity
    $m1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data . "entity"]);
    isTrue($m1->idx > 0, "create code: entityOne + $code");

    $d1 = meta()->delete(taxonomy: $taxonomy, entity: $entityOne);
    isTrue($d1->hasError == false, "delete success taxonomy, entity");

}
function deleteMetaTestViaTaxonomyCode()
{
    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-delete-tc' . time();
    $data = 'data' . time();
    // delete via taxonomy and code
    $m1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code, DATA => $data . "code"]);
    isTrue($m1->idx > 0, "create code: entityOne + $code");

    $d1 = meta()->delete(taxonomy: $taxonomy, code: $code);
    isTrue($d1->hasError == false, "delete success taxonomy, code");
}
function deleteMetaTestViaCode()
{
    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-delete-c' . time();
    $data = 'data' . time();

    // delete via code
    $c1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code . 1, DATA => $data . "entityOne"]);
    isTrue($c1->idx > 0, "create code: entityOne + $code");
    $c2 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code . 2, DATA => $data . "entityOne"]);
    isTrue($c2->idx > 0, "create code: entityOne + $code");

    $meta1 = meta()->get(taxonomy: $taxonomy, entity: $entityOne);
    isTrue(count($meta1) > 0, "meta should exist");
    isTrue($meta1[$code . 1] = $data . "entityOne", "meta code1 should exist");
    isTrue($meta1[$code . 2] = $data . "entityOne", "meta code2 should exist");

    $c1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code . 1, DATA => $data . "entityTwo"]);
    isTrue($c1->idx > 0, "create code: entityOne + $code");
    $c2 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityTwo, CODE => $code . 2, DATA => $data . "entityTwo"]);
    isTrue($c2->idx > 0, "create code: entityOne + $code");

    $meta2 = meta()->get(taxonomy: $taxonomy, entity: $entityTwo);
    isTrue(count($meta2) > 0, "meta should exist");
    isTrue($meta2[$code . 1] = $data . "entityTwo", "meta code1 should exist");
    isTrue($meta2[$code . 2] = $data . "entityTwo", "meta code2 should exist");

    // all code same code will be
    $d1 = meta()->delete(code: $code . 1);
    isTrue($d1->hasError == false, "delete success code");
    $d1 = meta()->delete(code: $code . 2);
    isTrue($d1->hasError == false, "delete success code");
    $m1 = meta()->get(taxonomy: $taxonomy, entity: $entityOne);

    isTrue(!isset($m1[$code . 1]), "meta code1 should not exist for entity $entityOne");
    isTrue(!isset($m1[$code . 2]), "meta code2 should not exist for entity $entityOne");

    $m2 = meta()->get(taxonomy: $taxonomy, entity: $entityTwo);
    isTrue(!isset($m2[$code . 1]), "meta code1 should not exist for entity $entityTwo");
    isTrue(!isset($m2[$code . 2]), "meta code2 should not exist for entity $entityTwo");
}

function deleteMetaTestViaEntity()
{
    $taxonomy = 'test';
    $entityOne = 1;
    $entityTwo = 2;
    $code = 'code-delete-e' . time();
    $data = 'data' . time();
    // delete via entity
    $c1 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code . 1, DATA => $data . "delete via entityOne"]);
    isTrue($c1->idx > 0, "create code: entityOne + $code");
    $c2 = meta()->create([TAXONOMY => $taxonomy, ENTITY => $entityOne, CODE => $code . 2, DATA => $data . "delete via  entityOne"]);
    isTrue($c2->idx > 0, "create code: entityOne + $code");

    $meta1 = meta()->get(taxonomy: $taxonomy,entity: $entityOne);
    isTrue(count($meta1) > 0, "meta should exist");
    isTrue($meta1[$code . 1] = $data . "entityOne", "meta code1 should exist and will be deleted via entity");
    isTrue($meta1[$code . 2] = $data . "entityOne", "meta code2 should exist and will be deleted via entity");

    $d1 = meta()->delete(entity: $entityOne);
    isTrue($d1->hasError == false, "delete success entity");
    $e1 = meta()->get(taxonomy: $taxonomy, entity: $entityOne);
    isTrue( count($e1) == 0 , "entity $entityOne should have 0 meta");
    isTrue( empty($e1), "entity $entityOne should have empty meta");

    $d2 = meta()->delete(entity: $entityTwo);
    isTrue($d2->hasError == false, "delete success entity");
    $e2 = meta()->get(taxonomy: $taxonomy, entity: $entityOne);

    isTrue( count($e2) == 0 , "entity $entityTwo should have 0 meta");
    isTrue( empty($e2), "entity $entityTwo should have empty meta");

}



function serializeTest() {

    isTrue( meta()->unserializeData( meta()->serializeData(0) ) === 0, "0 to be 0" );
    isTrue( meta()->unserializeData( meta()->serializeData(null) ) === null, "null must be null" );
    isTrue( meta()->unserializeData( meta()->serializeData(true) ) === true, "true to be true" );
    isTrue( meta()->unserializeData( meta()->serializeData(false) ) === false, "false to be false" );
    isTrue( meta()->unserializeData( meta()->serializeData([]) ) === [], "[] to be []" );
    $obj = new stdClass();
    $obj->a = 'apple';
    isTrue( meta()->unserializeData( meta()->serializeData($obj) )->a === $obj->a, "stdClass to be stdClass" );
}

function serializeObjectTest() {
    $tax = 'serializing' . time();
    $obj = new stdClass();
    $obj->a = 'apple';
    $obj->b = 'ba';

    $m = meta()->create([TAXONOMY => $tax, ENTITY => 0, CODE => 'obj', DATA => $obj]);
    $u = meta()->get($tax, 0);
    isTrue($u['obj']->b == $obj->b, "data serialized");

    $f = meta()->findOne([TAXONOMY => $tax, ENTITY => 0, CODE => 'obj']);

    isTrue($f->idx == $m->idx && $f->data->a == 'apple', 'found serialized data');
}