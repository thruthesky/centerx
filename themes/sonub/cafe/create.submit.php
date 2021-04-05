<?php
//if (isRealNameAuthUser() == false) return displayWarning('본인 인증을 한 사용자만 카페 개설이 가능합니다.');



$rootDomain = get_root_domain();

$len = strlen($rootDomain);

$inputDomain = strtolower(in('domain'));

$domain = $inputDomain . '.' . $rootDomain;

if ( ! in('countryCode') || strlen(in('countryCode')) != 2) {
    jsBack('앗! 교민 카페를 운영 할 국가를 선택해주세요.');
}



/**
 * 두 자리 국가 코드로는 도메인을 만들지 못하게 한다.
 */
$up = strtoupper($inputDomain);

if ( country($up)->exists ) {
    jsBack('앗! 이미 존재하는 도메인입니다. 다른 도메인을 입력하세요.');
}


if ( strlen($domain) > 32 ) {
    jsBack('앗! 도메인의 길이가 너무 깁니다. 좀 더 짧게 입력해주세요.');
}

if ( preg_match("/^[a-zA-z][0-9a-zA-z\-]+/", $inputDomain) ) {
    // 도메인이 올바름.
} else {
    jsBack('앗! 도메인은 알파벳으로 시작해야하고, 숫자와 하이픈(-)만 입력 가능합니다.');
}



$data = [
    USER_IDX => login()->idx,
    ID => $domain,
    DOMAIN => $rootDomain,
    'countryCode' => in('countryCode')
];
$cat = category()->create($data);

if ( $cat->hasError ) {
    jsBack($cat->getError() );
}


jsGo("https://$domain");