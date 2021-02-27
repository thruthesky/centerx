<?php


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



function live_reload_js()
{
    /// TODO print this only for localhost(local dev)
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
function setLoginCookies($profile) {
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
    $str= $profile[IDX] . $profile[CREATED_AT] . $profile[PASSWORD];
    return $profile[IDX] . '-' . md5($str);
}


/**
 * 로그인한 사용자의 User()->profile()을 리턴한다. 주의: 비밀번호 포함.
 * @return array|bool - 쿠키에 세션 정보가 없거나 올바르지 않으면 false 를 리턴한다.
 */
function getProfileFromCookieSessionId() : array|bool {
    if ( ! isset($_COOKIE[SESSION_ID]) ) return false;
    $arr = explode('-', $_COOKIE[SESSION_ID]);
    $profile = user($arr[0])->profile(unsetPassword: false);
    if ( $_COOKIE[SESSION_ID] == getSessionId($profile) ) return $profile;
    else return false;
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
