<?php
require_once ROOT_DIR . 'routes/notification.route.php';

setLogout();
testUpdateToken();
//testUpdateTokenWithTopic();
//testUpdateTokenWithMultipleTopics();
//
//testGetTokens();


function testUpdateToken() {
    $notificationRoute = new NotificationRoute();
    $re = $notificationRoute->updateToken([]);
    isTrue(  $re == e()->token_is_empty, 'should be token is empty');
    $re = $notificationRoute->updateToken([TOKEN=> 'abcd']);
    d($re);
//    isTrue(  $re['idx'], 'success with default topic');
//    isTrue(  $re[TOPIC] == DEFAULT_TOPIC, 'success with default topic: ' . DEFAULT_TOPIC);
//    isTrue(  $re[USER_IDX] == 0, 'user is not login must be 0');

}

//function testUpdateTokenWithTopic() {
//    $notificationRoute = new NotificationRoute();
//    $userA =  setLoginAny();
//    $re = $notificationRoute->updateToken([TOKEN=> 'abcd']);
//    isTrue(  $re[TOPIC] == DEFAULT_TOPIC, 'success with default topic: ' . DEFAULT_TOPIC);
//    isTrue(  $re[USER_IDX] == $userA->idx, 'user is not login must be equal to::' . $userA->idx);
//
//    $topic = 'topic' . time();
//    $re = $notificationRoute->updateToken([TOKEN=> 'abcd', TOPIC => $topic]);
//    isTrue(  $re[TOPIC] == $topic, 'success with specific topic: ' . $topic);
//}
//
//function testUpdateTokenWithMultipleTopics()
//{
//    $notificationRoute = new NotificationRoute();
//    $topic1 = 'topic' . time();
//    $topic2 = 'topic' . time() + 5;
//    $topic3 = 'topic' . time() + 10;
//    $userA =  setLoginAny();
//    $topics = $topic1 . "," . $topic2 . "," . $topic3;
//    $re = $notificationRoute->updateToken([TOKEN => 'abcd', TOPIC => $topics]);
//    isTrue($re[TOPIC] == $topic3, 'success with the last topic: ' . $topic3);
//}
//
//function testGetTokens(){
//    $notificationRoute = new NotificationRoute();
//    $topic1 = 'topic' . time();
//    $topic2 = 'topic' . time() + 5;
//    $topic3 = 'topic' . time() + 10;
//    $userA =  registerAndLogin();
//    $topics = $topic1 . "," . $topic2 . "," . $topic3;
//    $re = $notificationRoute->updateToken([TOKEN => 'abcd', TOPIC => $topics]);
//
//    $token = token()->getTokens($userA->idx);
//    d($token);
//    isTrue(count($token) == 1, 'must be 1 token only');
//    isTrue($token[0] == 'abcd', 'should be abcd');
//
//    $re = token()->getTopics($userA->idx);
//    d($re);
//}