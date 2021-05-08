<?php

$code = 'code'. time();

isTrue(cache($code)->exists() == false, "Expect: $code not exists");
isTrue(cache($code)->hasError, "Expect: $code not exists, thus hasError");
isTrue(cache($code)->getError() == e()->entity_not_found, "Expect: $code not exists, thus entity not found error.");

$cache = cache($code);
isTrue($cache->code == $code, "Expect: $code not exists, But, the code remains as {$cache->code}!");



$cache->renew();
isTrue(!$cache->createdAt, "Expect createdAt to be falsy");

$cache->set('yo');
isTrue($cache->createdAt > 0, "Expected a success" );
isTrue($cache->code == $code, "Expect: code as $code");
isTrue($cache->data == 'yo', "Expect data as yo");

$c = cache()->copyWith($cache);

sleep(3);

isTrue($cache->olderThan(2), "Expect cache is older than 2 seconds");
isTrue($cache->olderThan(10) == false, "Expect cache is not older than 10 seconds");


$cache->renew();
isTrue($cache->olderThan(2) == false, "Expect cache is not older than 2 seconds, because it is renewed.");



$cache->set('ho');
isTrue($c->idx == $cache->idx, "Expect same idx: {$c->idx}");
isTrue($c->data == 'yo', "Expect c->data yo");
isTrue($cache->data == 'ho', "Expect cache->data ho");

