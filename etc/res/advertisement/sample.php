<?php


login()->_setPoint(1000000);


/// banner settings
adminSettings()->set(MAXIMUM_ADVERTISING_DAYS, 30);
adminSettings()->set(ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, 2);
adminSettings()->set(ADVERTISEMENT_CATEGORIES, 'qna,discussion');


banner()->setMaxNoOn(TOP_BANNER);
banner()->setMaxNoOn(SIDEBAR_BANNER);
banner()->setMaxNoOn(SQUARE_BANNER);
banner()->setMaxNoOn(LINE_BANNER);

banner()->setMaxNoOn(TOP_BANNER, false);
banner()->setMaxNoOn(SIDEBAR_BANNER, false);
banner()->setMaxNoOn(SQUARE_BANNER, false);
banner()->setMaxNoOn(LINE_BANNER, false);

/**
 * PH
 *  GLOBAL TOP - 2
 *  GLOBAL SQUARE - 1
 *  GLOBAL LINE - 2
 *  QNA SQUARE - 1
 *  QNA LINE - 1  
 *  DISCUSSION SQUARE - 1
 *  DISCUSSION LINE - 2
 * 
 * AC
 *  GLOBAL TOP - 1
 *  GLOBAL SIDEBAR - 1
 *  GLOBAL SQUARE - 1
 */
$data = [
    /// AC GLOBAL TOP - 1
    [
        COUNTRY_CODE => 'AC',
        SUB_CATEGORY => '',
        CODE => TOP_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+2 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/g1.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "AC GLOBAL TOP 1",
        'content' => "AC GLOBAL TOP 1 CONTENT",
        CLICK_URL => 'https://naver.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// AC GLOBAL SIDEBAR - 1
    [
        COUNTRY_CODE => 'AC',
        SUB_CATEGORY => '',
        CODE => SIDEBAR_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/l_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "AC GLOBAL SIDEBAR 1",
        'content' => "AC GLOBAL SIDEBAR 1 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// AC GLOBAL SQUARE - 1
    [
        COUNTRY_CODE => 'AC',
        SUB_CATEGORY => '',
        CODE => SQUARE_BANNER,
        BEGIN_DATE => time(),
        END_DATE => strtotime('+3 days'),
        'files' => [
            'banner' => ROOT_DIR . 'etc/res/advertisement/img/sq_2.jpg',
            'content' => ROOT_DIR . 'etc/res/advertisement/img/c1.jpg',
        ],
        'title' => "AC GLOBAL SQUARE 1",
        'content' => "AC GLOBAL SQUARE 1 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ], 
    /// Global top PH - 1
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
        'title' => "PH GLOBAL TOP 1",
        'content' => "PH GLOBAL TOP 1 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Global square PH - 1
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
        'title' => "PH GLOBAL SQUARE 1",
        'content' => "PH GLOBAL SQUARE 1",
        PRIVATE_CONTENT => 'adv memo',
    ],
    // Global line PH - 2
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
        'title' => "PH GLOBAL LINE 1",
        'content' => "PH GLOBAL LINE 1 CONTENT",
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
        'title' => "PH GLOBAL LINE 2",
        'content' => "PH GLOBAL LINE 2 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// QNA Square PH - 1
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
        'title' => "PH QNA SQUARE 1",
        'content' => "PH QNA SQUARE 1 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Qna Line PH - 1
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
        'title' => "PH QNA LINE 1",
        'content' => "PH QNA LINE 1 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ],
    /// Discussion Square PH - 1
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
        'title' => "PH DISCUSSION SQUARE 1",
        'content' => "PH DISCUSSION SQUARE 1 CONTENT",
        PRIVATE_CONTENT => 'adv memo',
    ],
    // Discussion line PH - 2
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
        'title' => "PH DISCUSSION LINE 1",
        'content' => "PH DISCUSSION LINE 1 CONTENT",
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
        'title' => "PH DISCUSSION LINE 2",
        'content' => "PH DISCUSSION LINE 1 CONTENT",
        CLICK_URL => 'https://s8.philgo.com',
        PRIVATE_CONTENT => 'adv memo',
    ],
];
