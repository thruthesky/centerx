<?php


/**
 * 메인 카페 목록
 *
 * 여기에 기록된 메인 도메인은 2차 도메인이라도, 서브 카페(2차 도메인)로 인식되지 않고, 메인 카페로 인식된다.
 */
const CAFE_MAIN_DOMAINS = [
    'philov.com', 'www.philov.com', 'main.philov.com',
    'sonub.com', 'www.sonub.com',
];


/**
 * 카페의 루트 도메인 별로 특정 국가를 고정하고자할 때, 아래의 목록에 루트 도메인과 국가 코드, 사이트 이름, 홈 화면 이름 등을 추가하면 된다.
 *
 * 예를 들면, philov.com 도메인을 필리핀 국가로 고정하는 경우, countryCode 를 PH 로 하고, 해당 도메인으로 접속하면, 카페 생성할 때에 국가 선택을 보여주지 않는다. 또한 각종 커스터마이징에서 필리핀으로 고정을 시킨다.
 *
 * @주의 sonub.com 은 뺀다. sonub.com 은 특정 국가의 고정 도메인이 아니다.
 *
 * @see sonub/README.md
 */
const CAFE_COUNTRY_DOMAINS = [
    'philov.com' => [
        'countryCode' => 'PH',
        'name' => '필러브',
        'homeButtonLabel' => '홈',
    ],
];





const CAFE_MAIN_MENUS = [
    'qna' => [
        'title' => '질문게시판',
        'priority' => 40,
    ],
    'discussion' => [
        'title' => '자유게시판',
        'priority' => 30,
    ],
    'buyandsell' => [
        'title' => '회원장터',
        'priority' => 20,
    ],
    'reminder' => [
        'title' => '공지사항',
        'priority' => 0,
    ],
    'job' => [
        'title' => '구인구직',
        'priority' => 1,
    ],
    'rent_house' => [
        'title' => '주택임대',
        'priority' => 1,
    ],
    'rent_car' => [
        'title' => '렌트카',
        'priority' => 1,
    ],
    'im' => [
        'title' => '이민',
        'priority' => 1,
    ],
    'real_estate' => [
        'title' => '부동산',
        'priority' => 1,
    ],
    'money_exchange' => [
        'title' => '환전',
        'priority' => 1,
    ]
];