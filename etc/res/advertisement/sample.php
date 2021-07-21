<?php


login()->_setPoint(1000000);


/// banner settings
adminSettings()->set(MAXIMUM_ADVERTISING_DAYS, 30);
adminSettings()->set(ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, 2);






///
$data = [
    /// Global top - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => TOP_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+2 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Global banner",
        'content' => "This is global content",
        CLICK_URL => 'https://naver.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => TOP_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Global banner 2",
        'content' => "This is global banner content 2",
        CLICK_URL => 'https://daum.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Global square 
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => SQUARE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g_sq_1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Global banner 2",
        'content' => "This is global banner content 2",
        CLICK_URL => 'https://daum.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    // Global line - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g_l_1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Global banner 2",
        'content' => "This is global banner content 2",
        CLICK_URL => 'https://daum.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g_l_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Global banner 2",
        'content' => "This is global banner content 2",
        CLICK_URL => 'https://daum.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// QNA Square
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => SQUARE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "QNA Square 1",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Qna Line 
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/l_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "QNA line 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Discussion Square  
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'discussion',
        CODE => SQUARE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_3.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Discussion Square 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    // Discussion line - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'discussion',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/l_3.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Discussion Line 1",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'discussion',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Discussion Square 1",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],   
    // All country
    [
        COUNTRY_CODE => 'AC',
        SUB_CATEGORY => 'job',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/l_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "All Country Line 1",
        'content' => "All Country Line 1",
        PRIVATE_CONTENT => 'adv memo',
    ],   
    [
        COUNTRY_CODE => 'AC',
        SUB_CATEGORY => 'job',
        CODE => SQUARE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "All Country Square 1",
        'content' => "All Country Square 1",
        PRIVATE_CONTENT => 'adv memo',
    ], 
];
