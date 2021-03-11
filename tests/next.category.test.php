<?php

testCategory();
testCategoryCreate();
testCategoryUpdate();
testCategoryDelete();


function testCategory() {
    $cat = category();
    isTrue( get_class($cat) === 'Category', 'category() returns Category' );
}

function testCategoryCreate() {
    $id = 'category-create' . time();
    isTrue(category()->create([ID=>$id])->findOne([ID => $id])->read()->id == $id, "Expect ID: $id, but : ...");
}

function testCategoryUpdate() {
    $id = 'category-update' . time();
    $cat = category()->create([ID=>$id, 'no' => '123']);
    isTrue( $cat->no == '123', 'Expect: 123');
}

function testCategoryDelete() {
    $id = 'category-delete' . time();
    $cat = category()->create([ID=>$id, 'no' => '123']);
    isTrue( $cat->delete()->getData() == [], 'deleted');
    $find = category()->findOne([ID=>$id]);
    isTrue( $find->getError() == e()->entity_not_found, 'not found after delete');
}
