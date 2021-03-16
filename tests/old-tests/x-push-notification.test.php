<?php


$users = user()->search();

$topicQnA = 'qna' . time();
$topicDiscussion = 'discussion' . time();

setLogin($users[0]);
$record = pushNotification()->subscribeTopic(['topic'=>$topicQnA, 'tokens' => ['abc:token:--']]);
isTrue($record[$topicQnA] == 'Y', 'subscribe');

setLogin($users[1]);
$record = pushNotification()->subscribeTopic(['topic'=>$topicQnA, 'tokens' => 'abc:token:--']);
isTrue($record[$topicQnA] == 'Y', 'subscribe');

setLogin($users[2]);
$record = pushNotification()->subscribeTopic(['topic'=>$topicDiscussion, 'tokens' => 'abc:token:--']);
isTrue($record[$topicDiscussion] == 'Y', 'subscribe');


$meta = meta()->get('code', 'topic_qna');
$metas = meta()->search("taxonomy='users' AND code='$topicQnA' AND data='Y'", select: 'entity', limit: 10000);

foreach( $metas as $meta ) {
    isTrue( in_array($meta['entity'], [$users[0][IDX], $users[1][IDX]]), 'in');
    isTrue( ! in_array($meta['entity'], [$users[2][IDX], $users[3][IDX]]), 'out');
}









