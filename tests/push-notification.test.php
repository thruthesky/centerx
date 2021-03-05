<?php


$users = user()->search();

setLogin($users[0]);
$record = pushNotification()->subscribeTopic(['topic'=>'topic_qna', 'tokens' => ['abc:token:--']]);
isTrue($record['_qna'] == 'Y', 'subscribe');

setLogin($users[1]);
$record = pushNotification()->subscribeTopic(['topic'=>'topic_qna', 'tokens' => 'abc:token:--']);
isTrue($record['_qna'] == 'Y', 'subscribe');

setLogin($users[2]);
$record = pushNotification()->subscribeTopic(['topic'=>'topic_discussion', 'tokens' => 'abc:token:--']);
isTrue($record['_qna'] == 'Y', 'subscribe');


$meta = meta()->get('code', 'topic_qna');
$metas = meta()->search("taxonomy='users' AND code='topic_qna' AND data='Y'", select: 'entity', limit: 10000);
foreach( $metas as $meta ) {
    isTrue( in_array($meta['entity'], [$users[0][IDX], $users[1][IDX]]), 'in');
    isTrue( ! in_array($meta['entity'], [$users[2][IDX], $users[3][IDX]]), 'out');
}





