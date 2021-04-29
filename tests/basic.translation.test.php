<?php

testTranslationEntity();
testTranslationCreateCode();



function testTranslationEntity() {
    isTrue( get_class(translation()) == 'TranslationTaxonomy', 'is TranslationTaxonomy');
}


function testTranslationCreateCode() {
    $code = 'create' . time();
    isTrue(  translation()->createCode([]) == e()->empty_code, 'params empty on createCode');
    isTrue(  translation()->createCode([CODE => $code]) == $code, 'success return code');
}

function testTranslationUpdateCode() {
    $code = 'update' . time();
    isTrue(  translation()->createCode([CODE => $code]) == $code, 'success return code');

    //update code
    isTrue(  translation()->updateCode([])  == e()->empty_code, 'fail code is not set');
    isTrue(  translation()->updateCode([CODE => $code]) == $code, 'success return code');
}