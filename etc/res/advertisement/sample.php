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
    /// Global sidebar - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => SIDEBAR_BANNER,
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
        CODE => SIDEBAR_BANNER,
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
    /// Global square - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => SIDEBAR_BANNER,
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
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => '',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g_sq_2.jpg',
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
    /// Qna Top - 2
    [
        COUNTRY_CODE => 'PH',
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
        CLICK_URL => 'https://google.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => TOP_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/t2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Qna sidebar - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+2 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/t1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner",
        'content' => "This is banner content",
        CLICK_URL => 'https://google.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/t2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// QNA Square - 1
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Qna Line - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'qna',
        CODE => LINE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/l_1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
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
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Discussion Square - 2
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'discussion',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],    
    [
        COUNTRY_CODE => 'PH',
        SUB_CATEGORY => 'discussion',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_3.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    // Discussion line - 1
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
        'title' => "Top banner 2",
        'content' => "This is banner content 2",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
];
