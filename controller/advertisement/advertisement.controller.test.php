<?php
$now = new DateTime();

$re = request("advertisement.edit");
isTrue($re == e()->not_logged_in, "not logged in.");

setLoginAny();
$re = request("cafe.edit", [
    SESSION_ID => login()->sessionId
]);
isTrue($re == e()->empty_code, "empty code (banner type/place).");

$user = registerAndLogin();
$user->setPoint(10000);

request("cafe.edit", [
  SESSION_ID => login()->sessionId,
  CODE => TOP_BANNER,
  BEGIN_AT => $now->getTimestamp(),
  END_AT => $now->getTimestamp(),
]);
isTrue($user->point == 9000, "create TOP_BANNER for 1 day. deduct 1000 points to user.");

request("cafe.edit", [
  SESSION_ID => login()->sessionId,
  CODE => SIDEBAR_BANNER,
  BEGIN_AT => $now->getTimestamp(),
  END_AT => strtotime("+4 days"),
]);
isTrue($user->point == 6500, "create SIDEBAR_BANNER for 5 days. deduct 2500 points to user.");

