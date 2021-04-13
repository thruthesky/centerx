<?php

include_once ROOT_DIR . 'routes/in-app-purchase.route.php';

define('TEST_USER_IDX', 1);
//testServiceAccount();

//testIapLogin();
//testIapPlatformTest();
//testIapInputTest();
//testAndroidFailure();
//testAndroidRealData();
//testAndroidRealData2();
//testAndroidRealData3();




function testServiceAccount() {
    isTrue( file_exists(GCP_SERVICE_ACCOUNT_KEY_JSON_FILE_PATH) === true, 'Expected: service account json file exists');
}


function testIapLogin() {
    $inApp = inAppPurchase();
    $inApp->verifyPurchase([]);
    isTrue($inApp->getError() === e()->not_logged_in, e()->not_logged_in);

    setLoginAny();
    isTrue($inApp->verifyPurchase([])->getError() !== e()->not_logged_in, e()->not_logged_in);
}

function testIapPlatformTest() {
    setLoginAny();
    isTrue( inAppPurchase()->verifyPurchase([])->getError() == e()->empty_platform, 'Expect: empty platform');
    isTrue( inAppPurchase()->verifyPurchase(['platform' => 'andro'])->getError() == e()->wrong_platform, 'Expect: wrong platform');
    isTrue( inAppPurchase()->verifyPurchase(['platform' => 'iso'])->getError() == e()->wrong_platform, 'Expect: wrong platform');
    isTrue( inAppPurchase()->verifyPurchase(['platform' => 'ANDROID'])->getError() == e()->wrong_platform, 'Expect: wrong platform');
    isTrue( inAppPurchase()->verifyPurchase(['platform' => 'IOS'])->getError() == e()->wrong_platform, 'Expect: wrong platform');
}


function testIapInputTest() {

    $inApp = inAppPurchase();
    $serverVerificationData = "...";

    setLogin(TEST_USER_IDX);

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
    isTrue(is_string($inApp->response()) && strpos($inApp->response(), e()->receipt_invalid) === 0, e()->receipt_invalid);

}


function testAndroidFailure() {
    setLogin(TEST_USER_IDX);

    $iapRoute = new InAppPurchaseRoute();
    $data = [
        "sessionId" => login()->sessionId,
    ];
    isTrue( $iapRoute->recordFailure($data) == e()->empty_platform, 'Expect: empty platform');
    $data = [
        "platform" => "android",
        "sessionId" => login()->sessionId,
    ];
    isTrue( $iapRoute->recordFailure($data) == e()->empty_product_id, 'Expect: empty platform');

    $data = [
        "productID" => "point1000",
        "price" => "₩20,000",
        "title" => "20000 POINT (있수다)",
        "description" => "Please buy 20000 point.",
        "platform" => "android",
        "sessionId" => login()->sessionId,
    ];
    $res = $iapRoute->recordFailure($data);
    isTrue($res['idx'] > 0, 'Expect idx > 0');
    isTrue($res['status'] == 'failure', 'Expect status == failure');
}

function testAndroidRealData() {
    /// This is a real data from Play store in-app-purchase.
    /// You can use it to verify many times.
    /// You can change the session id.
    setLogin(TEST_USER_IDX);
    $data =[
        "productID" => "point1",
        "purchaseID" => "GPA.3375-6251-2358-30115",
        "price" => "₱43.00",
        "title" => "Point One (있수다)",
        "description" => "First price of the list",
        "transactionDate" => "1618220370451",
        "localVerificationData" => '{"orderId":"GPA.3375-6251-2358-30115","packageName":"com.itsuda50.app3","productId":"point1","purchaseTime":1618220370451,"purchaseState":0,"purchaseToken":"nkfeknhkpeeaojjakehbdabj.AO-J1Oy9nACH6LRGaoHg9XkWp0gAMtqFkJcaKWJLEvEgOvLD2gAngfgf5I2HoNIusPggK3GR-JsRWF1d3SL8cn1XKm8YKjXfqQ","acknowledged":false}',
        "serverVerificationData" => "nkfeknhkpeeaojjakehbdabj.AO-J1Oy9nACH6LRGaoHg9XkWp0gAMtqFkJcaKWJLEvEgOvLD2gAngfgf5I2HoNIusPggK3GR-JsRWF1d3SL8cn1XKm8YKjXfqQ",
        "platform" => "android",
        "route" => "in-app-purchase.verifyPurchase",
        "sessionId" => login()->sessionId,
    ];

    $iap = inAppPurchase()->verifyPurchase($data)->response();

    isTrue($iap['idx'] > 0, 'Expect idx > 0');
    isTrue($iap['status'] == 'success', 'Expect status == success');
    isTrue($iap['userIdx'] == login()->idx, 'Expect status == ' . login()->idx);
    isTrue($iap['platform'] == $data['platform'], 'Expect platform == ' . $data['platform']);
    isTrue($iap['localVerificationData_packageName'] == ANDROID_APP_ID, 'Expect localVerificationData_packageName == ' . ANDROID_APP_ID);
    isTrue($iap['productID'] == $data['productID'], 'Expect productID == ' . $data['productID']);
    isTrue($iap['price'] == $data['price'], 'Expect price == ' . $data['price']);
    isTrue($iap['title'] == $data['title'], 'Expect title == ' . $data['title']);
    isTrue($iap['description'] == $data['description'], 'Expect description == ' . $data['description']);
    isTrue($iap['transactionDate'] == $data['transactionDate'], 'Expect transactionDate == ' . $data['transactionDate']);
    isTrue($iap['localVerificationData'] == $data['localVerificationData'], 'Expect localVerificationData == ' . $data['localVerificationData']);
    isTrue($iap['serverVerificationData'] == $data['serverVerificationData'], 'Expect serverVerificationData == ' . $data['serverVerificationData']);


}

function testAndroidRealData2() {
    /// This is a real data from Play store in-app-purchase.
    /// You can use it to verify many times.
    /// You can change the session id.
    setLogin(TEST_USER_IDX);
    $data =[
        "productID" => "point1",
        "purchaseID" => "GPA.3331-2106-6893-67729",
        "price" => "₱43.00",
        "title" => "Point One (있수다)",
        "description" => "First price of the list",
        "transactionDate" => "1618221367376",
        "localVerificationData" => '{"orderId":"GPA.3331-2106-6893-67729","packageName":"com.itsuda50.app3","productId":"point1","purchaseTime":1618221367376,"purchaseState":0,"purchaseToken":"lfidbcbbjpefjjncbinanchj.AO-J1OweqjeVCo-bwLeGIvFlsELeTlFug3AtgDfR93fd_knX0jJJmkZLHZpoFeN56w9KYe-aguRC0SZEmgnLlbRaRUxuz6vOyQ","acknowledged":false}',
        "serverVerificationData" => "lfidbcbbjpefjjncbinanchj.AO-J1OweqjeVCo-bwLeGIvFlsELeTlFug3AtgDfR93fd_knX0jJJmkZLHZpoFeN56w9KYe-aguRC0SZEmgnLlbRaRUxuz6vOyQ",
        "platform" => "android",
        "route" => "in-app-purchase.verifyPurchase",
        "sessionId" => login()->sessionId,
    ];
    $iap = inAppPurchase()->verifyPurchase($data)->response();


    isTrue($iap['idx'] > 0, 'Expect idx > 0');
    isTrue($iap['status'] == 'success', 'Expect status == success');
    isTrue($iap['userIdx'] == login()->idx, 'Expect status == ' . login()->idx);
    isTrue($iap['platform'] == $data['platform'], 'Expect platform == ' . $data['platform']);
    isTrue($iap['localVerificationData_packageName'] == ANDROID_APP_ID, 'Expect localVerificationData_packageName == ' . ANDROID_APP_ID);
    isTrue($iap['productID'] == $data['productID'], 'Expect productID == ' . $data['productID']);
    isTrue($iap['price'] == $data['price'], 'Expect price == ' . $data['price']);
    isTrue($iap['title'] == $data['title'], 'Expect title == ' . $data['title']);
    isTrue($iap['description'] == $data['description'], 'Expect description == ' . $data['description']);
    isTrue($iap['transactionDate'] == $data['transactionDate'], 'Expect transactionDate == ' . $data['transactionDate']);
    isTrue($iap['localVerificationData'] == $data['localVerificationData'], 'Expect localVerificationData == ' . $data['localVerificationData']);
    isTrue($iap['serverVerificationData'] == $data['serverVerificationData'], 'Expect serverVerificationData == ' . $data['serverVerificationData']);

}

function testAndroidRealData3() {
    /// This is a real data from Play store in-app-purchase.
    /// You can use it to verify many times.
    /// You can change the session id.
    setLogin(TEST_USER_IDX);
    $data =[
        "productID" => "point2",
        "purchaseID" => "GPA.3321-1085-2237-12529",
        "price" => "₱87.00",
        "title" => "Point Two (있수다)",
        "description" => "Second price of the payment list",
        "transactionDate" => "1618223530042",
        "localVerificationData" => '{"orderId":"GPA.3321-1085-2237-12529","packageName":"com.itsuda50.app3","productId":"point2","purchaseTime":1618223530042,"purchaseState":0,"purchaseToken":"dejckkbpbifhkcobepmdpglb.AO-J1OxuVN-F8BhMmwM9XDt9Na0tSLC1rLLbaIJXXdp2G2dxHfCZMIhs2Mt3oEVGFrXucxjM-txL0Tfc57zVYqClKm0YAy7KQA","acknowledged":false}',
        "serverVerificationData" => "dejckkbpbifhkcobepmdpglb.AO-J1OxuVN-F8BhMmwM9XDt9Na0tSLC1rLLbaIJXXdp2G2dxHfCZMIhs2Mt3oEVGFrXucxjM-txL0Tfc57zVYqClKm0YAy7KQA",
        "platform" => "android",
        "route" => "in-app-purchase.verifyPurchase",
        "sessionId" => login()->sessionId,
    ];

    $iap = inAppPurchase()->verifyPurchase($data)->response();

    isTrue($iap['idx'] > 0, 'Expect idx > 0');
    isTrue($iap['status'] == 'success', 'Expect status == success');
    isTrue($iap['userIdx'] == login()->idx, 'Expect status == ' . login()->idx);
    isTrue($iap['platform'] == $data['platform'], 'Expect platform == ' . $data['platform']);
    isTrue($iap['localVerificationData_packageName'] == ANDROID_APP_ID, 'Expect localVerificationData_packageName == ' . ANDROID_APP_ID);
    isTrue($iap['productID'] == $data['productID'], 'Expect productID == ' . $data['productID']);
    isTrue($iap['price'] == $data['price'], 'Expect price == ' . $data['price']);
    isTrue($iap['title'] == $data['title'], 'Expect title == ' . $data['title']);
    isTrue($iap['description'] == $data['description'], 'Expect description == ' . $data['description']);
    isTrue($iap['transactionDate'] == $data['transactionDate'], 'Expect transactionDate == ' . $data['transactionDate']);
    isTrue($iap['localVerificationData'] == $data['localVerificationData'], 'Expect localVerificationData == ' . $data['localVerificationData']);
    isTrue($iap['serverVerificationData'] == $data['serverVerificationData'], 'Expect serverVerificationData == ' . $data['serverVerificationData']);

}