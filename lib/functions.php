<?php

use JetBrains\PhpStorm\NoReturn;


/**
 *
 * @note By default it returns null if the key does not exist.
 *
 *
 * @param $name
 * @param null $default
 * @return mixed
 *
 */
function in($name = null, $default = null): mixed
{

    // If the request is made by application/json content-type,
    // Then get the data as JSON input.
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (stripos($contentType, 'application/json') !== false) {
        $_REQUEST = get_JSON_input();
    }

    if ($name === null) {
        return $_REQUEST;
    }
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    } else {
        return $default;
    }
}


/**
 * JSON input from Client
 * @return mixed|null
 */
function get_JSON_input()
{

    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    // Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true);

    // If json_decode failed, the JSON is invalid.
    if (!is_array($decoded)) {
        return null;
    }

    return $decoded;
}



function d($obj) {
    echo "<xmp>";
    print_r($obj);
    echo "</xmp>";
}


/**
 * @return bool
 */
function is_cli(): bool
{
    return php_sapi_name() == 'cli';
}


/**
 * Returns true if the web is running on localhost (or developers computer).
 * @return bool
 */
function is_localhost(): bool
{

    if (is_cli()) return false;
    $localhost = false;
    $ip = $_SERVER['SERVER_ADDR'];
//    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || PHP_OS === 'Darwin') $localhost = true;
//    else {

        if (strpos($ip, '127.0.') !== false) $localhost = true;
        else if (strpos($ip, '192.168.') !== false) $localhost = true;
        else if ( strpos($ip, '172.') !== false ) $localhost = true;
//    }
    return $localhost;
}

/**
 * 모바일이면 참을 리턴한다.
 * @return bool
 */
function isMobile() {
    $mobileDetect = new \Detection\MobileDetect();
    return $mobileDetect->isMobile() || $mobileDetect->isTablet();
}

/**
 *
 */
function live_reload_js()
{
    /// API 콜 이라도, &reload=true 로 들어오면, live reload 한다.
    if ( in(ROUTE) && !in('reload') ) return;
    /// Don't display this javascript code for Mobile Web and App.
    if ( isMobile() ) return;

    if ( is_localhost() )
        echo <<<EOH
   <script src="https://main.philov.com:12345/socket.io/socket.io.js"></script>
   <script>
       var socket = io('https://main.philov.com:12345');
       socket.on('reload', function (data) {
           console.log(data);
           // window.location.reload(true);
           location.reload();
       });
   </script>
EOH;
}



/**
 * 도메인을 리턴한다.
 * 예) www.abc.com, second.host.abc.com
 * Returns requested url domain
 * @return string
 */
function get_host_name(): string
{
    if (isset($_SERVER['HTTP_HOST'])) return $_SERVER['HTTP_HOST'];
    else return '';
}


/**
 * Alias of get_host_name()
 * @return string
 */
function get_domain() : string
{
    return get_host_name();
}
/**
 * Alias of get_host_name()
 * @return string
 */
function get_domain_name(): string
{
    return get_host_name();
}


/**
 * 1차 도메인을 리턴한다.
 *
 * 예)
 * www.abc.co.kr -> abc.co.kr
 * apple.banana.philgo.com -> philgo.com
 *
 * @param string|null $_domain 테스트 할 도메인
 * @return string
 *
 * @see api/phpunit/GetDomainNamesTest.php for test.
 */
function get_root_domain(string $_domain = null): string {
    if ( $_domain == null ) $_domain = get_domain_name();
    if ( empty($_domain) ) return '';

    $_root_domains = ['.com', '.net', '.co.kr', '.kr'];
    foreach( $_root_domains as $_root ) {
        if ( stripos($_domain, $_root) !== false ) {
            $_without_root = str_ireplace($_root, '', $_domain);
            $_parts = explode('.', $_without_root);
            $_1st = array_pop($_parts);
            $_domain = $_1st . $_root;
            break;
        }
    }
    return $_domain;
}



function jsGo($url)
{
    echo "
    <script>
        location.href='$url';
    </script>
    ";
    exit;
}


/**
 * Javascript 로 돌아가기를 하고, PHP exit 한다.
 * @param $msg
 *
 */
function jsBack($msg) {
    echo "
    <script>
        alert('$msg');
        history.go(-1);
    </script>
    ";
    exit;
}


function jsAlert($msg)
{
    echo "
    <script>
        alert('$msg');
    </script>
    ";
    return 0;
}


/**
 * 문자열을 암호화한다.
 * @param $str
 * @return false|string|null
 */
function encryptPassword( $str ) {
    return password_hash( $str, PASSWORD_DEFAULT );
}


/**
 * 입력된 plain text 문자열이 암호화된 문자열과 동일한지 확인한다.
 * Returns true if password matches.
 *
 * @param $plain_text_password
 * @param $encrypted_password
 * @return bool
 *
 * @code
 *      if ( ! checkPassword( in('old_password'), $user->password ) ) return ERROR_WRONG_PASSWORD;
 * @endcode
 */
function checkPassword( $plain_text_password, $encrypted_password ) {
    return password_verify( $plain_text_password, $encrypted_password );
}



/**
 * Set login cookies
 * 입력된 $profile 정보로 해당 사용자를 로그인 시킨다.
 *
 * When user login, the session_id must be saved in cookie. And it is shared with Javascript.
 * @param $profile
 */
function setLoginCookies(mixed $profile) {
    if ( is_numeric($profile) ) {
        $profile = user($profile)->profile();
    }
    setcookie ( SESSION_ID , $profile[SESSION_ID], time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
    if ( isset($profile[NICKNAME]) ) setcookie ( NICKNAME , $profile[NICKNAME] , time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
    if ( isset($profile[PROFILE_PHOTO_URL]) ) setcookie ( PROFILE_PHOTO_URL , $profile[PROFILE_PHOTO_URL] , time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
}

/**
 * Set login cookies
 *
 * When user login, the session_id must be saved in cookie. And it is shared with Javascript.
 * @param $profile
 */
function unsetLoginCookies() {
    setcookie(SESSION_ID, "", time()-3600, '/', COOKIE_DOMAIN);
    setcookie(NICKNAME, "", time()-3600, '/', COOKIE_DOMAIN);
    setcookie(PROFILE_PHOTO_URL, "", time()-3600, '/', COOKIE_DOMAIN);
}


/**
 * 사용자의 세션 ID 를 리턴한다.
 * 비밀번호를 변경하면, 세션 ID 도 같이 변경한다. 즉, 세션 ID 는 변경이 된다.
 * @param $profile
 * @return false|string|null
 */
function getSessionId($profile) {
    if ( !$profile ) return null;
    $str= $profile[IDX] . $profile[CREATED_AT] . $profile[PASSWORD];
    return $profile[IDX] . '-' . md5($str);
}


/**
 * 로그인한 사용자의 User()->profile()을 리턴한다. 주의: 비밀번호 포함.
 * @return array|bool - 쿠키에 세션 정보가 없거나 올바르지 않으면 false 를 리턴한다.
 *
 * 예제) 쿠키에 있는 정보로 회원 로그인을 시킬 때, 아래와 같이 한다.
 *  setUserAsLogin(getProfileFromCookieSessionId());
 */
function getProfileFromCookieSessionId() : array|bool {
    if ( ! isset($_COOKIE[SESSION_ID]) ) return false;
    return getProfileFromSessionId($_COOKIE[SESSION_ID]);
//
//    $arr = explode('-', $_COOKIE[SESSION_ID]);
//    $profile = user($arr[0])->profile(unsetPassword: false);
//    if ( $_COOKIE[SESSION_ID] == getSessionId($profile) ) return $profile;
//    else return false;
}

/**
 * Let user login with sessionId.
 *
 * @param string $sessionId
 * @return mixed
 * - false if `sessionId` is empty.
 * - error_user_not_found if there is no user by that session_id.
 * - error_wrong_session_id if the sessionId is wrong.
 * - or user profile if there is no error.
 *
 * 예제) 세션 아이디를 입력받아 해당 사용자를 로그인 시킬 때,
 *  setUserAsLogin( getProfileFromSessionId( in(SESSION_ID) ) );
 */
function getProfileFromSessionId(string|null $sessionId): mixed
{
    if ( ! $sessionId ) return false;
    $arr = explode('-', $sessionId);
    $userIdx = $arr[0];
    $record = user($userIdx)->get();
    if ( ! $record ) return e()->user_not_found_by_that_session_id;
    $profile = user($userIdx)->profile(unsetPassword: false);
	if ( !$profile || !isset($profile[SESSION_ID]) ) return false;
    if ( $sessionId == $profile[SESSION_ID] ) return $profile;
    else return e()->wrong_session_id;
}




/**
 * @return bool
 *
 * 예제)
 *      d(loggedIn() ? 'loggedIn' : 'not loggedIn');
 *      d(login()->profile());
 */
function loggedIn(): bool {
    return login()->loggedIn;
}
function notLoggedIn(): bool {
    return ! loggedIn();
}


/**
 * 로그인한 사용자의 프로필을 담는 변수.
 *
 * 이 변수에 사용자 프로필이 있으면 그 사용자가 로그인을 한 사용자가 된다. 로그인 사용자를 변경하고자 한다면 이 변수를 다른 사용자의 users 레코드를 넣으면 된다.
 * 이 변수를 직접 사용하지 말고, 사용자 로그인을 시킬 때에는 setUserAsLogin() 을 쓰고, 사용 할 때에는 login() 을 사용하면 된다.
 */
global $__login_user_profile;
/**
 * @param $profile
 */
function setUserAsLogin($profile): void {
    global $__login_user_profile;
    $__login_user_profile = $profile;
}

/**
 * Returns login user record field.
 *
 * Note, that it does not only returns `wc_users` table, but also returns from `wc_metas` table.
 *
 * @param string $field
 * @return mixed|null
 */
function my(string $field) {
    if ( loggedIn() ) {
        $profile = login()->profile();
        if ( isset($profile[$field]) ) {
            return $profile[$field];
        }
    }
    return null;
}

function admin(): bool {
    return my(EMAIL) == config()->get(ADMIN);
}

function debug_log($message, $data='') {
    $str = print_r($message, true);
    $str .= ' ' . print_r($data, true);
    file_put_contents(DEBUG_LOG_FILE_PATH, $str . "\n");
}


/**
 *
 * - widget_id 가 없으면, 설정을 하지 않는다. 즉, 설정없이 그냥 사용하는 것이다.
 * - 최소 한번만 설정을 한다, 따라서, 설정을 매번 스크립트가 로드할 때마다 바꾸고 싶다면, $widgetId 를 변경해 주면 된다.
 *
 * @param string $path
 * @param array $options
 * @param string $widgetId
 */
$__widget_options = null;
function get_widget_options() {
    global $__widget_options;
    return $__widget_options;
}
function widget(string $path, array $options=[], string $widgetId=null) {
    global $__widget_options;
    $__widget_options = $options;
    if ( $widgetId ) entity('widget')->setMetaIfNotExists(0, $widgetId, $options );
    $arr = explode('/', $path);
    $_path = ROOT_DIR . "/widgets/$arr[0]/$arr[1]/$arr[1].php";
    return $_path;
}


/**
 * @attention Use this function only for Api call.
 * @param string $code
 */
function error(string $code) {
    success($code);
}

/**
 * @attention Use this function only for Api call.
 * @param mixed $data
 */
function success(mixed $data) {
    echo json_encode([
        'response' => $data,
        'request' => in(),
    ]);
    exit;
}

/**
 * $__routes holds routes functions.
 */
$__routes = [];
function routeAdd($routeName, $func) {
    global $__routes;
    $__routes[ $routeName ] = $func;
}

/**
 * Return route function or false.
 * @param string|null $routeName
 * @return mixed
 */
function getRoute(string|null $routeName): mixed
{
    global $__routes;
    if ( isset($__routes[$routeName]) ) return $__routes[$routeName];
    return false;
}


/**
 * @param $email
 *
 * @return bool
 */
function checkEmailFormat($email): bool
{

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

