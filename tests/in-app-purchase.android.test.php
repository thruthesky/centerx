<?php

include_once ROOT_DIR . 'routes/in-app-purchase.route.php';

//testServiceAccount();

//testIapLogin();
//testIapEmptyPlatform();
//testIapInputTest();
//testAndroidFailure();
testAndroidRealData();



function testServiceAccount() {
    isTrue( file_exists(SERVICE_ACCOUNT_LINK_TO_APP_JSON_FILE_PATH) === true, 'Expected: service account json file exists');
}


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
    $serverVerificationData = "...";

    setLoginAny();

    $inputData = [
        'platform' => 'android'
    ];

    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_id, 'Expected: ' . e()->empty_product_id);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_purchase_id,e()->empty_purchase_id);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_price,e()->empty_product_price);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_title,e()->empty_product_title);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => 'One Thousand Pesos',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_product_description,e()->empty_product_description);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_transaction_date,e()->empty_transaction_date);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_local_verification_data,e()->empty_local_verification_data);


    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_server_verification_data,e()->empty_server_verification_data);

    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
        'serverVerificationData' => $serverVerificationData,
    ];
    $inApp->verifyPurchase($inputData);
    isTrue($inApp->getError() === e()->empty_package_name,e()->empty_package_name);


    $inputData = [
        'platform' => 'android',
        'productID' => 'product_ID_101',
        'purchaseID' => 'purchase_ID_abcd',
        'price' => 'P1000',
        'title' => '1k Item',
        'description' => 'One Thousand Pesos Item',
        'transactionDate' => '1234567890',
        'localVerificationData' => 'localVerificationData_this_qwertyuio',
        'serverVerificationData' => $serverVerificationData,
        'localVerificationData_packageName' => 'purchase_ID_abcd'
    ];
    $inApp->verifyPurchase($inputData);



    /// TODO UPDATE WHEN THE VERIFICATION FUNCTION IS WORKING

//    $inputData = [
//        'platform' => 'android',
//        'productID' => 'product_ID_101',
//        'purchaseID' => 'purchase_ID_abcd',
//        'price' => 'P1000',
//        'title' => '1k Item',
//        'description' => 'One Thousand Pesos Item',
//        'transactionDate' => '1234567890',
//        'localVerificationData' => 'localVerificationData_this_qwertyuio',
//        'serverVerificationData' => $serverVerificationData,
//        'localVerificationData_packageName' => 'purchase_ID_abcd'
//    ];
//    $iap = $inApp->verifyPurchase($inputData);
//    isTrue(is_string($iap->response()) && strpos($iap->response(), e()->receipt_invalid) === 0, e()->receipt_invalid);

}


function testAndroidFailure() {
    setLoginAny();
    $data = [
        "productID" => "",
        "purchaseID" => "",
        "price" => "₩20,000",
        "title" => "20000 POINT (있수다)",
        "description" => "Please buy 20000 point.",
        "transactionDate" => "",
        "localVerificationData" => "",
        "serverVerificationData" => "",
        "platform" => "android",
        "route" => "in-app-purchase.recordFailure",
        "sessionId" => login()->sessionId,
    ];

    $iapRoute = new InAppPurchaseRoute();
    $res = $iapRoute->recordFailure($data);
    isTrue($res['idx'] > 0, 'Expect idx > 0');
    isTrue($res['status'] == 'failure', 'Expect status == failure');
}

function testAndroidRealData() {
    /// This is a real data from Play store in-app-purchase.
    /// You can use it to verify many times.
    /// You can change the ssession id.
    setLoginAny();
    $data =[
        "productID" => "point1000",
        "purchaseID" => "GPA.3369-3869-6910-36525",
        "price" => "₩1,000",
        "title" => "1000 points (있수다)",
        "description" => "1000 points",
        "transactionDate" => "1617094334951",
        "localVerificationData" => '{"orderId":"GPA.3369-3869-6910-36525","packageName":"com.itsuda50.app","productId":"point1000","purchaseTime":1617094334951,"purchaseState":0,"purchaseToken":"nfpjmjdplclocdocelbbaakg.AO-J1OyiXKWb5EKBRfKsTPyh3apot90P7De0GNUxrzoces1jp9VOYFHmyqRxs_V8HxEOpkfusmrgOVrEG4uaqsQWEDK3GymZ0w","acknowledged":false}',
        "serverVerificationData" => "nfpjmjdplclocdocelbbaakg.AO-J1OyiXKWb5EKBRfKsTPyh3apot90P7De0GNUxrzoces1jp9VOYFHmyqRxs_V8HxEOpkfusmrgOVrEG4uaqsQWEDK3GymZ0w",
        "platform" => "android",
        "route" => "in-app-purchase.verifyPurchase",
        "sessionId" => login()->sessionId,
    ];
    $iap = inAppPurchase()->verifyPurchase($data);
    d($iap);


}