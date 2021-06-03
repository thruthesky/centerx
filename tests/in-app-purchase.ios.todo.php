<?php

testIapLogin();
testIapEmptyPlatform();
testIapInputTest();

function testIapLogin() {
    $inApp = inAppPurchase();
    $inApp->verifyPurchase([]);
    isTrue($inApp->getError() === e()->not_logged_in, e()->not_logged_in);

    setLoginAny();
    isTrue($inApp->verifyPurchase([])->getError() !== e()->not_logged_in, e()->not_logged_in);
}

function testIapEmptyPlatform() {
    setLoginAny();
    isTrue( inAppPurchase()->verifyPurchase([])->getError() == e()->empty_platform, 'Expect: empty platform');
}
function testIapInputTest() {
    $inApp = inAppPurchase();
    $serverVerificationData = ".........";

    $inputData = [
        'platform' => 'ios'
    ];
    isTrue($inApp->verifyPurchase($inputData)->getError() === e()->empty_product_id, 'Expecte: ' . e()->empty_product_id);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_purchase_id,e()->empty_purchase_id);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_price,e()->empty_product_price);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_title,e()->empty_product_title);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => 'One Thousand Pesos',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_description,e()->empty_product_description);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_transaction_date ,e()->empty_transaction_date);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_local_verification_data, 'Expect: ' . e()->empty_local_verification_data);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
    ];
    $inApp->verifyPurchase($inputData);

    isTrue($inApp->getError() === e()->empty_server_verification_data,e()->empty_server_verification_data);
    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'quantity' => '777',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
        'serverVerificationData' => $serverVerificationData,
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_identifier, 'Expect: ' . e()->empty_product_identifier);


    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'quantity' => '777',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
        'serverVerificationData' => $serverVerificationData,
        'transactionIdentifier' => '987654321',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_transaction_timestamp ,e()->empty_transaction_timestamp);

    $inputData = [
        'platform' => 'ios',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'quantity' => '777',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
        'serverVerificationData' => $serverVerificationData,
        'transactionIdentifier' => '987654321',
        'transactionTimeStamp' => '99999.88',
    ];
    $inApp->verifyPurchase($inputData);

}

