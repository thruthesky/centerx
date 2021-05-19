<?php
require_once ROOT_DIR . 'routes/notification.route.php';

setLogout();
testSaveToken();
testUpdateToken();
testUpdateTokenWithMultipleTopics();

testGetTokensAndTopics();


function testSaveToken() {
    $notificationRoute = new NotificationRoute();
    registerAndLogin();
    $re = $notificationRoute->updateToken([]);
    isTrue(  $re == e()->token_is_empty, 'should be token is empty');
    $re = $notificationRoute->updateToken([TOKEN => 'abcd' . time()]);
    isTrue(  count($re), 'must return an array with success or fail');
    isTrue(  $re[0][DEFAULT_TOPIC] == true, 'success with default topic must be true: ' . DEFAULT_TOPIC);
}
function testUpdateToken() {
    $notificationRoute = new NotificationRoute();
    registerAndLogin();
    $token = 'testUpdateToken' . time();
    $token1 = $notificationRoute->updateToken([TOKEN => $token]);
    $token2 = $notificationRoute->updateToken([TOKEN=> $token, TOPIC => "newTopic"]);
    isTrue( $token1[0][DEFAULT_TOPIC] == true, "defaultTopic was created");
    isTrue( $token2[0]["newTopic"] == true , 'newTopic was created');
}


function testUpdateTokenWithMultipleTopics()
{
    $notificationRoute = new NotificationRoute();
    $topic1 = 'topic' . time();
    $topic2 = 'topic' . time() + 5;
    $topic3 = 'topic' . time() + 10;
    registerAndLogin();
    $topics = $topic1 . "," . $topic2 . "," . $topic3;
    $re = $notificationRoute->updateToken([TOKEN => 'abcd', TOPIC => $topics]);
    isTrue(count($re) == 3, 'must be 3');
    isTrue($re[0][$topic1] == true, 'must be true: ' . $topic1);
    isTrue($re[1][$topic2] == true, 'must be true: ' . $topic2);
    isTrue($re[2][$topic3] == true, 'must be true: ' . $topic3);
}

function testGetTokensAndTopics(){
    $notificationRoute = new NotificationRoute();
    $topic1 = 'topic' . time();
    $topic2 = 'topic' . time() + 5;
    $topic3 = 'topic' . time() + 10;
    $userA =  registerAndLogin();
    $topics = $topic1 . "," . $topic2 . "," . $topic3;
    $notificationRoute->updateToken([TOKEN => 'abcd', TOPIC => $topics]);

    $tokens = token()->getTokens($userA->idx);
    isTrue(count($tokens) == 3, 'must be 3 token');
    isTrue($tokens[0] == $tokens[1]  &&  $tokens[2] == 'abcd', 'should be abcd');

    $topics = token()->getTopics($userA->idx);
    isTrue(count($topics) == 3, 'must be 3 topics');

    $myToken = token()->myTokens();
    $t = true;
    foreach($tokens as $i => $token) {
        if ($token!= $myToken[$i]) $t = false;
    }
    isTrue($t, 'must be true that both tokens have same value');

    $myTopics = token()->myTopics();
    $t = true;
    foreach($topics as $i => $topic) {
        if ($topic!= $myTopics[$i]) $t = false;
    }
    isTrue($t, 'must be true that both topics have same value');
}