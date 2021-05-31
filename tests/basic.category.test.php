<?php
//
//testCategory();
//testCategoryCreate();
//testCategoryUpdate();
//testCategoryDelete();
//
//
//
//function testCategory() {
//    $cat = category();
//    isTrue( get_class($cat) === 'CategoryModel', 'category() returns CategoryModel' );
//}
//
//function testCategoryCreate() {
//    $id = 'category-create' . time();
//    isTrue(category()->create([ID=>$id])->findOne([ID => $id])->read()->id == $id, "Expect ID: $id, but : ...");
//}
//
//function testCategoryUpdate() {
//    $id = 'category-update' . time();
//    $cat = category()->create([ID=>$id, 'no' => '123']);
//    isTrue( $cat->no == '123', 'Expect: 123');
//}
//
//function testCategoryDelete() {
//    // create
//    $id = 'category-delete' . time();
//    $cat = category()->create([ID=>$id, 'no' => '123']);
//
//    // delete
//    isTrue( $cat->delete()->hasError == false, 'deleted');
//    isTrue( $cat->idx > 0, 'deleted');
//    isTrue( $cat->id == $id, 'id will be remain only on memory.');
//
//    // check if deleted
//    $find = category()->findOne([ID => $id]);
//    isTrue( $find->getError() == e()->entity_not_found, 'not found after delete');
//}
