<?php

/// banner settings
adminSettings()->set(MAXIMUM_ADVERTISING_DAYS, 30);
adminSettings()->set(ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, 2);


///
$data = [
    [
        SUB_CATEGORY => 'qna',
        CODE => TOP_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+2 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/t1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner",
        'content' => "This is banner content",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
];
