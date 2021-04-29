<?php

testTranslationEntity();
testTranslationCreateCode();
testTranslationRead();
testTranslationUpdateCode();
testTranslationDeleteCode();


testTranslationText();



function testTranslationEntity() {
    isTrue( get_class(translation()) == 'TranslationTaxonomy', 'is TranslationTaxonomy');
}


function testTranslationCreateCode() {
    $code = 'create' . time();
    // create code
    isTrue(  translation()->createCode([]) == e()->empty_code, 'params empty on createCode');
    isTrue(  translation()->createCode([CODE => $code]) == $code, 'success return code');
    // try to create with the same code
    isTrue(  translation()->createCode([CODE => $code]) == e()->code_exists, 'create with the same code');
}

function testTranslationRead() {
    $code = 'Read' . time();
    isTrue(  translation()->createCode([
        CODE => $code,
            'en' => 'english',
            'ko'=> 'korean',
            'xx' => 'not supported'
        ]) == $code, 'success return code');

    $c = translation()->load();
    isTrue(isset($c[$code]), 'code must exist');
    isTrue($c[$code]['en'] == 'english', 'en must be english');
    isTrue($c[$code]['ko'] == 'korean', 'kr must be korean');
    isTrue(!isset($c[$code]['xx']), 'not supported');
}



function testTranslationUpdateCode() {
    $code1 = 'updatecode1' . time();
    $code2 = 'updatecode2' . time();
    // create code1
    isTrue(  translation()->createCode([CODE => $code1]) == $code1, 'success return code1');

    //update code
    isTrue(  translation()->updateCode([])  == e()->empty_code, 'fail code is not set');
    isTrue(  translation()->updateCode([CODE => $code1, CURRENT_CODE_NAME => $code1]) == $code1, 'update with same code.');

    // create code 2
    isTrue(  translation()->createCode([CODE => $code2]) == $code2, 'success return code2');
    // update code1 with code2. must error
    isTrue(  translation()->updateCode([CODE => $code2, CURRENT_CODE_NAME => $code1]) == e()->code_exists, 'code already exist');
    // update with not existing code
    isTrue(  translation()->updateCode([CODE => $code1 . 'abcd', CURRENT_CODE_NAME => $code1]) == $code1 . 'abcd', 'success, new code ' . $code1 . 'abcd');
}


function testTranslationDeleteCode() {
    $code = 'Read' . time();
    // create code
    isTrue(  translation()->createCode([
            CODE => $code,
            'en' => 'e',
            'ko'=> 'k',
        ]) == $code, 'success return code');

    // check if code was created
    $c = translation()->load();
    isTrue(isset($c[$code]), 'code must exist');

    // deleted code
    $deletedCode = translation()->deleteCode($code);

    //check if code was deleted
    $c = translation()->load();
    isTrue(!isset($c[$deletedCode]), 'code should not exist');
}


function testTranslationText() {
    $code = 'text' . time();
    // create code
    isTrue(  translation()->createCode([
            CODE => $code,
            'en' => 'eee',
            'ko'=> 'kkk',
        ]) == $code, 'success return code');

    $en = translation()->text('en', $code);
    isTrue($en == 'eee', 'must be eee');
    $ko = translation()->text('ko', $code);
    isTrue($ko == 'kkk', 'must be kkk');

    $ph = translation()->text('ph', $code);
    isTrue($ph == '', 'empty/not exist');
}


