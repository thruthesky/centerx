<?php
require_once ROOT_DIR . 'routes/notification.route.php';
setLogout();
testUpdateToken();


function testUpdateToken() {
    $notificationRoute = new NotificationRoute();
    $re = $notificationRoute->updateToken([]);
    isTrue(  $re == e()->token_is_empty, 'success return code');
    $re = $notificationRoute->updateToken([TOKEN=> 'abcd']);
    isTrue(  $re == e()->token_is_empty, 'success return code');
    d($re);
}