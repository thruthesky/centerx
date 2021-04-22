<?php

define('REASON', 'reason');
define('FROM_USER_IDX', 'fromUserIdx');
define('TO_USER_IDX', 'toUserIdx');

define('POINT_UPDATE', 'POINT_UPDATE');

define('POINT_LIKE', 'POINT_LIKE');
define('POINT_DISLIKE', 'POINT_DISLIKE');

define('POINT_LIKE_DEDUCTION', 'POINT_LIKE_DEDUCTION');
define('POINT_DISLIKE_DEDUCTION', 'POINT_DISLIKE_DEDUCTION');

define('POINT_ITEM_ORDER', 'POINT_ITEM_ORDER');
define('POINT_ORDER_CONFIRM', 'POINT_ORDER_CONFIRM');
define('POINT_ITEM_RESTORE', 'POINT_ITEM_RESTORE');

define('POINT_LIKE_HOUR_LIMIT', 'POINT_LIKE_HOUR_LIMIT');
define('POINT_LIKE_HOUR_LIMIT_COUNT', 'POINT_LIKE_HOUR_LIMIT_COUNT');
define('POINT_LIKE_DAILY_LIMIT_COUNT', 'POINT_LIKE_DAILY_LIMIT_COUNT');
define('POINT_HOUR_LIMIT', 'POINT_HOUR_LIMIT');
define('POINT_HOUR_LIMIT_COUNT', 'POINT_HOUR_LIMIT_COUNT');
define('POINT_DAILY_LIMIT_COUNT', 'POINT_DAILY_LIMIT_COUNT');
define('BAN_ON_LIMIT', 'BAN_ON_LIMIT');

define('ERROR_HOURLY_LIMIT', 'ERROR_HOURLY_LIMIT');
define('ERROR_DAILY_LIMIT', 'ERROR_DAILY_LIMIT');

define('POINT_POST_CREATE', 'POINT_POST_CREATE');
define('POINT_POST_DELETE', 'POINT_POST_DELETE');
define('POINT_COMMENT_CREATE', 'POINT_COMMENT_CREATE');
define('POINT_COMMENT_DELETE', 'POINT_COMMENT_DELETE');
define('POINT_REGISTER', 'POINT_REGISTER');
define('POINT_LOGIN', 'POINT_LOGIN'); // 로그인만 해도 포인트
define('POINT_TEST', 'POINT_TEST');


/// 포인트 충전
define('POINT_PURCHASE', 'POINT_PURCHASE');

/// 포인트 충전은 원화 뿐만아니라, PHP, USD 등 여러 나라 통화로 결제가 된다. 따라서, 결제되는 금액을 바탕으로 포인트를 충전하기 어렵다.
/// 플레이스토어 또는 앱스토어에서 Product ID 별로 결제하는 금액이 정해지고, 각 국가별 통화로 정해지므로, 여기서는 Product ID 별로 충전하고자 하는 포인트를
/// 원화로 기반해서 충전하면 된다.
/// 그리고, Android 와 iOS 별 결제금액이 다르므로 충전 포인트도 다르다. 예를 들면, iOS 에는 9,900 원 포인트 결제가 없다.
/// 물론, Android 결제 금액을 iOS 에 억지로 맞추면 되기도하지만, 수수료(세금) 문제가 있을 수 있다.
/// Android 와 iOS 별로 기본 수수료가 다르므로 결제되는 금액과 충전되는 포인트에 차이가 있을 수 있다.
define('ANDROID_POINT_PURCHASE_AMOUNT', [
    'point1' => 10000,
    'point2' => 20000,
    'point3' => 30000,
    'point5' => 50000,
    'point10' => 100000,
]);
define('IOS_POINT_PURCHASE_AMOUNT', [
    'point1' => 9900,
    'point2' => 20000,
    'point3' => 30000,
    'point5' => 50000,
    'point10' => 99000,
]);






define('POINT_POST_COMMENT_ACTIONS', [POINT_POST_CREATE, POINT_POST_DELETE, POINT_COMMENT_CREATE, POINT_COMMENT_DELETE]);
define('POINT_LIKE_ACTIONS', [POINT_LIKE, POINT_DISLIKE]);
define('REASONS', [
    POINT_UPDATE,
    POINT_TEST,

    POINT_LIKE,
    POINT_DISLIKE,

    POINT_POST_CREATE,
    POINT_POST_DELETE,
    POINT_COMMENT_CREATE,
    POINT_COMMENT_DELETE,

    POINT_REGISTER,
    POINT_LOGIN,
]);
