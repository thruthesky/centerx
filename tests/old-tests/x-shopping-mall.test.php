<?php


include ROOT_DIR . 'routes/shopping-mall.route.php';

$route = new ShoppingMallRoute();

setLogout();
$re = $route->order([]);
isTrue($re == e()->not_logged_in, print_r($re, true));


$user = setLoginAny();
$user->_setPoint(0);


$re = $route->order([]);
isTrue($re == e()->wrong_params, e()->wrong_params);


$info = json_encode([
    'pointToUse' => 3000,
    ]);

// 포인트 부족
$re = $route->order(['info' => $info]);
isTrue($re == e()->lack_of_point, "re: " . print_r($re, true));

// 포인트 충분
$user->_setPoint(5000);
$orderRecord = $route->order(['info' => $info]);

isTrue($user->getPoint() == 2000, 'point should be 2000');


$history = pointHistory()->last(SHOPPING_MALL_ORDERS, $orderRecord[IDX]);


isTrue( login()->idx === $history->value('toUserIdx'), "My idx: " . login()->idx . " vs userIdx: " . $history->value('toUserIdx'));
isTrue($history->value('toUserPointApply') == -3000, 'toUserPointApply: 3000');

// 취소
$deletedRecord = $route->cancelOrder([IDX=>$orderRecord[IDX]]);

isTrue($orderRecord[IDX] == $deletedRecord[IDX]);
isTrue($user->getPoint() == 5000, 'point should be 5000');


// 상품 등록.
// 상품 구매.
// 구매한 상품 후기 등록.
// 확정된 구매만 후기 등록 가능.
