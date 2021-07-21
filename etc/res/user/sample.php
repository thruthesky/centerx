<?php


// 샘플 사용자를 생성한다.
//
$data = [];
for($i=0; $i<10; $i++) {

    $data[] = [
        'email' => "email" . $i . time() . '@test.com',
        'password' => '12345a',
        'photo' => ROOT_DIR . "etc/res/user/img/$i.jpg",
        'nickname' => $i. "번유저",
    ];
}