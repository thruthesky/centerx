<?php


include ROOT_DIR . 'routes/shopping-mall.route.php';

$route = new ShoppingMallRoute();

$re = $route->order([]);
isTrue($re == e()->not_logged_in, e()->not_logged_in);


$user = setLoginAny();
$user->setPoint(0);

$re = $route->order([]);
isTrue($re == e()->wrong_params, e()->wrong_params);


$info = json_encode([
    'pointToUse' => 3000,
    ]);

// 포인트 부족
$re = $route->order(['info' => $info]);
isTrue($re == e()->lack_of_point);

// 포인트 충분
$user->setPoint(5000);
$orderRecord = $route->order(['info' => $info]);

isTrue($user->getPoint() == 2000, 'point should be 2000');


$history = pointHistory()->last(SHOPPING_MALL_ORDERS, $orderRecord[IDX]);


isTrue(my(IDX) === $history->value('toUserIdx'), "My idx: " . my(IDX) . " vs userIdx: " . $history->value('toUserIdx'));
isTrue($history->value('toUserPointApply') == 3000, 'toUserPointApply: 3000');

$deletedRecord = $route->cancelOrder([IDX=>$orderRecord[IDX]]);

isTrue($orderRecord[IDX] == $deletedRecord[IDX]);
isTrue($user->getPoint() == 5000, 'point should be 5000');

