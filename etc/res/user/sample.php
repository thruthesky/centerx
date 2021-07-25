<?php


// 샘플 사용자를 생성한다.
//
$data = [];
$names = ['이서영', '김자인', '구용자', '이영우', '김말숙', '유서한', '임의우', '김세용', '구나홍', '김재덕'];
for($i=0; $i<10; $i++) {
    $data[] = [
        'email' => "email" . $i . time() . '@test.com',
        'password' => '12345a',
        'photo' => ROOT_DIR . "etc/res/user/img/$i.jpg",
        'nickname' => $names[$i],
    ];
}