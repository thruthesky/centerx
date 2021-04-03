<?php
/**
 * @file kill-wrong-routes
 */
///
///
/// This script detects if wrong accesses and kills.
///
/// 때로는, 알 수 없는 이상한 접속이 있는데, 그러한 접속을 이곳에서 차단시킨다.
/// 예를 들면,
/// - 해킹을 시도하는 접속이나,
/// - Javascript 등에서 잘못된 접속이나
/// - 이미지 경로 등이 잘못된 경우 등이 있을 수 있다.
/// - 그리고, 새로운 도메인에 적용된 IP 주소가 이전에 다른 도메인으로 사용되던 것이 었는데, 호스팅 중단으로, 그 도메인이 살아 있고, IP 도 여전히 바뀌지 않았다면,
///   이전 사이트의 URL 이 들어온다.
/// - 그리고 favicon.ico 등 여러가지 접속이 있을 수 있다.
/// - 또한 검색 Bot 등도 이 곳에서 걸러 낼 수 있다.
///
///  이와 같이, 원하지 않는 접속을 차단 한다.
///
///


/// Favicon
///
/// @attention Favicon must exists and should not come here.
///

if ( isset($_SERVER['REQUEST_URI']) ) {
    if ( strpos($_SERVER['REQUEST_URI'], 'favicon.ico') !== false ) {
        exit;
    }
}

/// Map files
///
/// @attention Request of `.map` files are killed. So, map cannot be used even for development.
///
if ( isset($_SERVER['REQUEST_URI']) ) {
    if ( strpos($_SERVER['REQUEST_URI'], '.map') > 0 ) {
        exit;
    }
}
