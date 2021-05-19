<?php
require_once ROOT_DIR . 'routes/notification.route.php';

setLogout();
testSaveToken();
testUpdateToken();
testUpdateTokenWithMultipleTopics();

testGetTokens();


function testSaveToken() {
    $notificationRoute = new NotificationRoute();
    registerAndLogin();
    $re = $notificationRoute->updateToken([]);
    isTrue(  $re == e()->token_is_empty, 'should be token is empty');
    $re = $notificationRoute->updateToken([TOKEN => 'abcd' . time()]);
    isTrue(  $re['idx'], 'success with default topic');
    isTrue(  $re[TOPIC] == DEFAULT_TOPIC, 'success with default topic: ' . DEFAULT_TOPIC);
}
function testUpdateToken() {
    $notificationRoute = new NotificationRoute();
    registerAndLogin();
    $token = 'testUpdateToken' . time();
    $token1 = $notificationRoute->updateToken([TOKEN => $token]);
    $token2 = $notificationRoute->updateToken([TOKEN=> $token, TOPIC => "newTopic"]);
    isTrue( $token1[IDX] != $token2[IDX], "New record created");
    isTrue( $token2[TOPIC] == "newTopic", 'success with default topic: newTopic');
}


function testUpdateTokenWithMultipleTopics()
{
    $notificationRoute = new NotificationRoute();
    $topic1 = 'topic' . time();
    $topic2 = 'topic' . time() + 5;
    $topic3 = 'topic' . time() + 10;
    $userA =  registerAndLogin();
    $topics = $topic1 . "," . $topic2 . "," . $topic3;
    $re = $notificationRoute->updateToken([TOKEN => 'abcd', TOPIC => $topics]);
    isTrue($re[TOPIC] == $topic3, 'success with the last topic: ' . $topic3);
}

function testGetTokens(){
    $notificationRoute = new NotificationRoute();
    $topic1 = 'topic' . time();
    $topic2 = 'topic' . time() + 5;
    $topic3 = 'topic' . time() + 10;
    $userA =  registerAndLogin();
    $topics = $topic1 . "," . $topic2 . "," . $topic3;
    $re = $notificationRoute->updateToken([TOKEN => 'abcd', TOPIC => $topics]);

    $token = token()->getTokens($userA->idx);
//    d($token);
    isTrue(count($token) == 3, 'must be 3 token');
    isTrue($token[0] == $token[1]  &&  $token[2] == 'abcd', 'should be abcd');

    $re = token()->getTopics($userA->idx);
    isTrue(count($token) == 3, 'must be 3 topics');
}