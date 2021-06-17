<?php

$re = request("translation.update");
isTrue($re == e()->code_is_empty, 'update empty code');

$code = 'create' . time();
$re = request(
    "translation.update",
    [
        CODE => $code,
        'en' => "en-code",
        'ko' => "ko-code"
    ]
);
isTrue($re[CODE] == $code, 'must return code');


$re = request("translation.list");
isTrue(isset($re['en'][$code]) && $re['en'][$code] == "en-code", 'en must be set');
isTrue(isset($re['ko'][$code]) && $re['ko'][$code] == "ko-code", 'ko must be set');