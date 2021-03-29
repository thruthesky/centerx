<?php
require_once '/root/boot.php';

testPurchaseInputTest();
function testPurchaseInputTest() {

    $inApp = inAppPurchase();
    $serverVerificationData = "......";

    $inputData = [];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->not_logged_in, e()->not_logged_in);

    setLoginAny();
    $inputData = [];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_platform, e()->empty_platform);

    $inputData = [
        'platform' => 'IOS'
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_product_id,e()->empty_product_id);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_purchase_id,e()->empty_purchase_id);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_product_price,e()->empty_product_price);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_product_title,e()->empty_product_title);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => 'One Thousand Pesos',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_product_description,e()->empty_product_description);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_transaction_date ,e()->empty_transaction_date);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_product_identifier ,e()->empty_product_identifier);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_quantity ,e()->empty_quantity);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'quantity' => '777',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_transaction_identifier ,e()->empty_transaction_identifier);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'quantity' => '777',
        'transactionIdentifier' => '987654321',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_transaction_timestamp ,e()->empty_transaction_timestamp);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'quantity' => '777',
        'transactionIdentifier' => '987654321',
        'transactionTimeStamp' => '99999.88',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_local_verification_data ,e()->empty_local_verification_data);

    $inputData = [
        'platform' => 'IOS',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'productIdentifier' => 'same_as_product_id',
        'quantity' => '777',
        'transactionIdentifier' => '987654321',
        'transactionTimeStamp' => '99999.88',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue($re === e()->empty_server_verification_data,e()->empty_server_verification_data);

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
        'transactionIdentifier' => '987654321',
        'transactionTimeStamp' => '99999.88',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
        'serverVerificationData' => $serverVerificationData,
        'applicationUsername' => '',
    ];
    $re = $inApp->verifyPurchase($inputData)->response();
    isTrue(is_string($re) && strpos($re, e()->receipt_invalid) === 0, e()->receipt_invalid);

}

