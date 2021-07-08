<?php

require_once ROOT_DIR . 'controller/friend/friend.controller.php';

db()->query("TRUNCATE " . friend()->getTable());



$friendRoute = new FriendController();
setLoginAny();



// 실패. 존재하지 않는 회원 번호.
// Expect failure. non-existent user idx.
$res = $friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => 123456789]);
isTrue($res == e()->user_not_found_by_that_idx, '실패 예상. 회원번호가 너무 큼. 존재하지 않는 번호.');

// 실패. 자신 자신을 추가 할 수 없음.
$res = $friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => login()->idx]);
isTrue($res == e()->cannot_add_oneself_as_friend, '실패 예상. 자기 자신을 친구로 추가 할 수 없음.');

// 성공.
$res = $friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res['idx'] > 0, '성공. 다른 친구 추가 했음');

// 실패. 이미 추가한 친구를 다시 추가 할 수 없음.
$res = $friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res == e()->already_added_as_friend, '실패. 추가한 친구를 다시 추가 할 수 없음.');

// 실패. 추가되지 않은 친구를 삭제 할 수 없음.
$res = $friendRoute->delete(['sessionId' => login()->sessionId, 'otherIdx' => 123456789]);
isTrue($res == e()->not_added_as_friend, '실패 예상. 추가되지 않은 친구를 삭제 할 수 없음.');

// 성공. 친구 삭제. 2nd 사용자 친구 삭제.
$res = $friendRoute->delete(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res['idx'] > 0, '성공. 친구 삭제.');

// 실패. 존재하지 않는 사용자 차단.
$res = $friendRoute->block(['sessionId' => login()->sessionId, 'otherIdx' => 1234567890]);
isTrue($res == e()->entity_not_found, '실패 예상. 존재하지 않는 사용자를 차단 할 수 없음.');

// 성공. 친구가 아닌 사용자를 차단.
$res = $friendRoute->block(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res['idx'] > 0, '성공. 친구가 아닌 사용자를 차단.');
$res = $friendRoute->delete(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);


// 성공. 친구 추가 후, 차단
$res = $friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
$res = $friendRoute->block(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res['block'] == 'Y', '성공. 블럭 되었음.');

// 실패. 차단 된 친구를 다시 차단 할 수 없음.
$res = $friendRoute->block(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res == e()->already_blocked, '실패. 차단된 친구를 다시 차단 할 수 없음.');

// 성공. 차단 해제.
$res = $friendRoute->unblock(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res['idx'] > 0, '성공. 차단 해제');



// 실패. 차단되지 않은 친구를 차단 해제 할 수 없음.
$res = $friendRoute->unblock(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
isTrue($res == e()->not_blocked, '실패 예약. 차단되지 않은 친구를 차단 해제 할 수 없음.');


// 친구 목록. 친구 2명 추가.
$friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
$friendRoute->add(['sessionId' => login()->sessionId, 'otherIdx' => getThirdUser()->idx]);
$friends = $friendRoute->list();
isTrue(count($friends) == 2, '성공, 친구: 2명');
$friends = $friendRoute->blockList();
isTrue(count($friends) == 0, '성공, 차단 된 친구: 0명');

// 차단된 목록. 1명 차단.
$friendRoute->block(['sessionId' => login()->sessionId, 'otherIdx' => getSecondUser()->idx]);
$friends = $friendRoute->list();
isTrue(count($friends) == 1, '성공, 친구: 1명');
$friends = $friendRoute->blockList();
isTrue(count($friends) == 1, '성공, 차단 된 친구: 1명');


// 신고. 친구 신고 기능은, block 을 할 때, 단순히, reason 필드에 값만 추가하면 된다.
// 2초 쉬었다가, 친구 신고. block=Y 로 되는데, createdAt 과 updatedAt 의 값이 달라져야 한다. 그리고 updatedAt 으로 정렬해서, 최근에 신고된 목록을 볼 수 있다.
sleep(2);
$friendRoute->block(['sessionId' => login()->sessionId, 'otherIdx' => getThirdUser()->idx, 'reason' => 'I do not like this person']);
$friends = $friendRoute->blockList();
isTrue(count($friends) == 2, '성공, 차단 된 친구: 2명');


// 신고된 사용자 목록. 관리자가 필요한 기능.
// List users who are reported by other user. Admin may need this functionality.
$friends = $friendRoute->reportList();
isTrue(count($friends) == 1, 'Expect success. No of reported users: 1.'); // 성공, 신고된 사용자 목록: 1명


