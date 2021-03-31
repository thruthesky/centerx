<?php

include_once ROOT_DIR . 'routes/in-app-purchase.route.php';

//testServiceAccount();

//testIapLogin();
//testIapPlatformTest();
testIapInputTest();
//testAndroidFailure();
//testAndroidRealData();
//testAndroidRealData2();
//testAndroidRealData3();



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

    setLogin(1);

    $inputData = [
        'platform' => 'android'
    ];

    $inApp->verifyPurchase($inputData);
    d($inApp->getError());
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
    setLogin(1);

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
    /// You can change the ssession id.
    setLogin(1);
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
    setLogin(5);
    $data =[
        "productID" => "point1000",
        "purchaseID" => "GPA.3330-4674-5099-66226",
        "price" => "₱43.00",
        "title" => "1000 points (있수다)",
        "description" => "1000 points",
        "transactionDate" => "1617165610775",
        "localVerificationData" => '{"orderId":"GPA.3330-4674-5099-66226","packageName":"com.itsuda50.app","productId":"point1000","purchaseTime":1617165610775,"purchaseState":0,"purchaseToken":"mpmbckfmbkfoffjeldlafami.AO-J1OwZQN-Ry4x0fyN8Md6cOdNLSkDNZmsd3SlCj0L7CKx1xMwKw04ymETYC6ufVNW4-9aejdN0Q7Rvl3ycB2AuGu6A_KyG1A","acknowledged":false}',
        "serverVerificationData" => "mpmbckfmbkfoffjeldlafami.AO-J1OwZQN-Ry4x0fyN8Md6cOdNLSkDNZmsd3SlCj0L7CKx1xMwKw04ymETYC6ufVNW4-9aejdN0Q7Rvl3ycB2AuGu6A_KyG1A",
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
    setLogin(5);
    $data =[
        "productID" => "point1000",
        "purchaseID" => "GPA.3345-6696-2095-56231",
        "price" => "₱43.00",
        "title" => "1000 points (있수다)",
        "description" => "1000 points",
        "transactionDate" => "1617166686512",
        "localVerificationData" => '{"orderId":"GPA.3345-6696-2095-56231","packageName":"com.itsuda50.app","productId":"point1000","purchaseTime":1617166686512,"purchaseState":0,"purchaseToken":"kgbbangopllminbjjegifnkg.AO-J1OyPvXidBJZfp6eaKDXxhCchVtSgvJGphDZUCbnp4yyXHZrV0qxHFedEivsR5NaLWBCGRoKT7u35F2RcioGSls1PXmALnQ","acknowledged":false}',
        "serverVerificationData" => "kgbbangopllminbjjegifnkg.AO-J1OyPvXidBJZfp6eaKDXxhCchVtSgvJGphDZUCbnp4yyXHZrV0qxHFedEivsR5NaLWBCGRoKT7u35F2RcioGSls1PXmALnQ",
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