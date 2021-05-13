<?php
/**
 * @file functions.php
 */
use PHPHtmlParser\Dom;


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



function d($obj, $msg = null) {
//    print_r(debug_backtrace());
    if ( isCli() || isTesting() ) echo "\nd(): ";
    else echo "<xmp>";
    if ($msg) echo "\n$msg\n";
    print_r($obj);
    if ( isCli() || isTesting() ) echo "\n";
    else echo "</xmp>";
}


/**
 * @return bool
 */
function isCli(): bool
{
    return php_sapi_name() == 'cli';
}


/**
 * Returns true if the web is running on localhost (or developers computer).
 * @return bool
 */
function isLocalhost(): bool
{
    if (isCli()) return false;
    if ( in_array(get_domain_name(), LOCAL_HOSTS) ) return true;
    return false;
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
 * Live reload
 *
 * When PHP, Javascript, CSS files are edited, the browser will automatically reload.
 *
 * @note This method display live reload javascript code ONLY when `node live-reload.js` is running
 *  And when it should do 'live-reload'.
 */
function live_reload()
{
    if ( canLiveReload() ) {
        $rootUrl = LIVE_RELOAD_HOST;
        $port = LIVE_RELOAD_PORT;

        $url = "$rootUrl:$port/socket.io/socket.io.js";

        echo <<<EOH
    <script src="$url"></script>
    <script>
        if( window.Cypress || typeof io === 'undefined') {
            // Don't watch for live-reload if it is Cypress testing or failed to load socket.io.js (that means, live-reload.js is not running)
        } else {
            console.log("Live reload enabled...");
            var socket = io("$rootUrl:$port/");
            socket.on('reload', function (data) {
                console.log('live reloading...', data);
                location.reload();
            });            
        }
    </script>
EOH;
    }
}






function canLiveReload(): bool {


    if ( ! LIVE_RELOAD_HOST ) return false;

    /// API call 이면, false. 단, reload 에 값이 들어오면, reload.
    if ( API_CALL ) {
        if ( ! in('reload') ) return false;
    }
    /// CLI 에서 실행하면 false
    if ( isCli() ) return false;
    /// PhpThumb 이면 false
    if ( isPhpThumb() ) return false;

    /// 로컬 도메인이 아니면, false
    if ( isLocalhost() == false ) return false;

    return true;

//    return !API_CALL && !isCli() && !isPhpThumb();
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
 * Returns the root url of current page(url) including ending slash(/).
 * If HOME_URL is set, then it will use HOME_URL as its root url.
 * @return string
 */
function get_current_root_url(): string {
    if ( ! isset($_SERVER['HTTP_HOST']) ) return DEFAULT_HOME_URL;
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . '/';
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


    foreach( SUPPORTED_DOMAIN_SUFFIX as $_root ) {
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


function jsAlertGo($msg, $url)
{
    echo "
    <script>
        alert('$msg');
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
 * 로그인한 사용자의 프로필을 담는 변수.
 *
 * 이 변수에 사용자 프로필이 있으면 그 사용자가 로그인을 한 사용자가 된다. 로그인 사용자를 변경하고자 한다면 이 변수를 다른 사용자의 users 레코드를 넣으면 된다.
 * 이 변수를 직접 사용하지 말고, 사용자 로그인을 시킬 때에는 setUserAsLogin() 을 쓰고, 사용 할 때에는 login() 을 사용하면 된다.
 */
global $__login_user_profile;

/**
 * Set the user of $profile as logged into the system.
 *
 * @attention, it does not save login information into cookies. It only set the user login in current session.
 *
 * @param int|array $profile
 * @return UserTaxonomy
 * @todo memory cache login user object
 */
function setUserAsLogin(int|array $profile): UserTaxonomy {
    global $__login_user_profile;
    if ( is_int($profile) ) $profile = user($profile)->getData();
    $__login_user_profile = $profile;
    return user($profile[IDX] ?? 0);
}


function setLogout() {
    global $__login_user_profile;
    $__login_user_profile = [];
}

/**
 * 문자열을 암호화한다.
 * MD5 가 아니라, 더 복잡한 암호화를 한다.
 *
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
 * @param array|int $profile
 *   - 숫자이면, 회원 번호로 인식해서 회원 정보를 가져온다.
 */
function setLoginCookies(array|int $profile): void {
    if ( is_numeric($profile) ) {
        $profile = user($profile)->profile();
    }

    setAppCookie(SESSION_ID , $profile[SESSION_ID]);
    if ( isset($profile[NICKNAME]) ) setAppCookie ( NICKNAME , $profile[NICKNAME] );
    if ( isset($profile[PROFILE_PHOTO_URL]) ) setAppCookie ( PROFILE_PHOTO_URL , $profile[PROFILE_PHOTO_URL] );

//    setcookie ( SESSION_ID , $profile[SESSION_ID], time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
//    if ( isset($profile[NICKNAME]) ) setcookie ( NICKNAME , $profile[NICKNAME] , time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
//    if ( isset($profile[PROFILE_PHOTO_URL]) ) setcookie ( PROFILE_PHOTO_URL , $profile[PROFILE_PHOTO_URL] , time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
}

/**
 * Set login cookies
 *
 * When user login, the session_id must be saved in cookie. And it is shared with Javascript.
 * @param $profile
 */
function unsetLoginCookies() {
    deleteAppCookie(SESSION_ID);
    deleteAppCookie(NICKNAME);
    deleteAppCookie(PROFILE_PHOTO_URL);
//    setcookie(SESSION_ID, "", time()-3600, '/', COOKIE_DOMAIN);
//    setcookie(NICKNAME, "", time()-3600, '/', COOKIE_DOMAIN);
//    setcookie(PROFILE_PHOTO_URL, "", time()-3600, '/', COOKIE_DOMAIN);
}

function setAppCookie($name, $value) {
//    $name = md5($name);
    setcookie ( $name , $value, time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
}

function deleteAppCookie($name) {
//    $name = md5($name);
    setcookie($name, "", time()-3600, '/', COOKIE_DOMAIN);
}

function getAppCookie($name) {
//    $name = md5($name);
    if ( !isset($_COOKIE[$name]) ) return null;
    else return $_COOKIE[$name];
}



/**
 * 사용자의 세션 ID 를 리턴한다.
 * 비밀번호를 변경하면, 세션 ID 도 같이 변경한다. 즉, 세션 ID 는 변경이 된다.
 * @param $profile
 * @return false|string|null
 */
function getSessionId($profile) {
    if ( !$profile || !isset($profile[IDX]) ) return null;
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
    $sid = getAppCookie(SESSION_ID);
    if ( empty($sid) ) return false;
    return getProfileFromSessionId($sid);
}

/**
 * Let user login with sessionId.
 *
 * @param string $sessionId
 * @return array|bool|string
 * - false if `sessionId` is empty.
 * - error_user_not_found if there is no user by that session_id.
 * - error_wrong_session_id if the sessionId is wrong.
 * - or user profile if there is no error.
 *
 * 예제) 세션 아이디를 입력받아 해당 사용자를 로그인 시킬 때,
 *  setUserAsLogin( getProfileFromSessionId( in(SESSION_ID) ) );
 */
function getProfileFromSessionId(string $sessionId): array|bool|string
{
    if ( ! $sessionId ) return false;
    $arr = explode('-', $sessionId);
    $userIdx = $arr[0];
    $user = user($userIdx);
    if ( $user->notFound ) return e()->user_not_found_by_that_session_id;
    $profile = $user->profile();
    if ( !$profile || !isset($profile[SESSION_ID]) ) return false;

    if ( $sessionId == $profile[SESSION_ID] ) return $profile;
    else {
        return e()->wrong_session_id;
    }
}




/**
 * 로그인을 했는지 안했는지만 확인한다.
 * @return bool
 *
 * 예제)
 *      d(loggedIn() ? 'loggedIn' : 'not loggedIn');
 *      d(login()->profile());
 */
function loggedIn(): bool {
    return login(IDX) ? true: false;
//    global $__login_user_profile;
//    if ( isset($__login_user_profile) && $__login_user_profile && isset($__login_user_profile[IDX]) ) {
//        return true;
//    }
//    return false;
}
function notLoggedIn(): bool {
    return ! loggedIn();
}


function admin(): bool {
    if ( login()->idx == 0 ) return false;
    if ( str_contains(ADMIN_EMAIL, login()->email) ) return true;
    return login()->email === config()->get(ADMIN);
}

function debug_log($message, $data='') {
    $str = print_r($message, true);
    $str .= ' ' . print_r($data, true);
//    file_put_contents(DEBUG_LOG_FILE_PATH, $str . "\n", FILE_APPEND);
    error_log($str, 3, DEBUG_LOG_FILE_PATH);
}


/**
 *
 * - widget_id 가 없으면, 설정을 하지 않는다. 즉, 설정없이 그냥 사용하는 것이다.
 * - 최소 한번만 설정을 한다, 따라서, 설정을 매번 스크립트가 로드할 때마다 바꾸고 싶다면, $widgetId 를 변경해 주면 된다.
 *
 * @param string $path
 * @param array $options
 *
 * @return string
 * @example
 *  include widget('post-latest/post-latest-default')
 */
function widget(string $path, array $options=[]) {
//    if ( $widgetId && $options ) addMetaIfNotExists('widget', 0, $widgetId, $options);

    setWidgetOptions($options);
    $arr = explode('/', $path);
    $path = ROOT_DIR . "widgets/$arr[0]/$arr[1]/$arr[1].php";
    return $path;
}

$__widget_options = [];
function setWidgetOptions(array $options) {
    global $__widget_options;
    $__widget_options = $options;
}
function getWidgetOptions() {
    global $__widget_options;
    return $__widget_options;
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
    header('Content-Type: application/json');
    echo json_encode([
        'response' => $data,
        'request' => in(),
    ]);
    exit;
}

/**
 * Custom Api Route 를 추가한다.
 * $__routes holds routes functions.
 *
 * 참고로, 훅과 다르게 Api Route 는 같은 Route 에 여러개의 함수를 정의 할 수 없고, 하나만 정의 할 수 있다.
 */
$__routes = [];
function addRoute($routeName, $func) {
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


/**
 * Safe file name to write in HDD.
 * @param string $name
 * @return string
 */
function safeFilename(string $name) {
    $pi = pathinfo($name);
    if ( isset($pi['extension']) ) {
        $name = $pi['filename'];
    }
    $name = seoFriendlyString($name);
    if ( isset($pi['extension']) ) {
        $name = $name . '.' . $pi['extension'];
    }
    return $name;
}

/**
 * Transform the $s into SEO friendly.
 *
 * It can be used to convert a filename into safe file name when uploading files.
 *
 * Ex) 'Hotels in Buenos Aires' => 'hotels-in-buenos-aires'
 *
 *    - converts all alpha chars to lowercase
 *    - not allow two "-" chars continued, convert them into only one single "-"
 *
 * @param string $s
 * @return string
 */
function seoFriendlyString(string $s): string {

    $s = trim($s);

    $s = html_entity_decode($s);

    $s = strip_tags($s);


    // 모두 소문자로 변경한다.
    $s = strtolower($s);

    // 여러개의 --- 를 한개의 - 로 변경한다.
    $s = preg_replace('~-+~', '-', $s);

    // 여러개의 공백을 한개의 공백으로 변경한다.
    $s = preg_replace('/ +/', ' ', $s);

    // 특수 문자를 없애거나 - 로 대체한다.

    $s = str_replace("+"," ", $s); // 특히, + 문자는 문제를 일으킬 소지가 많다. 그렇다고 + 를 - 로 변경하면 의미가 크게 변경 될 수 있다. 그래서 공백으로 변경을 한다.
    $s = str_replace('`', '', $s);
    $s = str_replace('~', ' ', $s);
    $s = str_replace('!', ' ', $s);
    $s = str_replace('@', '', $s);
    $s = str_replace('#', ' ', $s);
    $s = str_replace('$', '', $s);
    $s = str_replace('%', '', $s);
    $s = str_replace('^', '', $s);
    $s = str_replace('&', ' ', $s);
    $s = str_replace('*', '', $s);
    $s = str_replace('(', '', $s);
    $s = str_replace(')', '', $s);
    $s = str_replace('_', '', $s);
    $s = str_replace('=', ' ', $s);
    $s = str_replace('\\', '', $s);
    $s = str_replace('|', '', $s);
    $s = str_replace('{', '', $s);
    $s = str_replace('[', '', $s);
    $s = str_replace(']', '', $s);
    $s = str_replace('"', '', $s);
    $s = str_replace("'", '', $s);
    $s = str_replace(';', '', $s);
    $s = str_replace(':', '', $s);
    $s = str_replace('/', '', $s);
    $s = str_replace('?', '', $s);
    $s = str_replace('.', ' ', $s);
    $s = str_replace('<', '', $s);
    $s = str_replace('>', '', $s);
    $s = str_replace(',', ' ', $s);

    $s = trim($s, '- ');

    return $s;
}


/**
 * HTML FORM 을 전송할 때 반드시, mode 값이 create, update, delete, submit 중에 하나라야 한다.
 * Helper function to detect if form have submitted for creation
 * @return bool
 */
function modeCreate(): bool {
    return in('mode') == 'create';
}
/**
 * Helper function to detect if form have submitted for update
 * @return bool
 */
function modeUpdate(): bool {
    return in('mode') == 'update';
}
/**
 * Helper function to detect if form have submitted for delete
 * @return bool
 */
function modeDelete(): bool {
    return in('mode') == 'delete' || in('button') == 'delete';
}

/**
 * Helper function to detect if form have submitted
 * @return bool
 */
function modeSubmit(): bool {
    return in('mode') == 'submit';
}

/**
 * HTML FORM 이 전송되었는지 검사한다.
 * @return bool
 */
function modeAny(): bool {
    $mode = in('mode');
    return !empty($mode);
}

/**
 *
 */
function bsAlert($text) {
    echo <<<EOH
<div class="alert alert-secondary">$text</div>
EOH;

}


/**
 * Returns true if the $data is php serialize().
 *
 * @usage Use this to check if a value is php serialized. so, you can unserialize(). Especially on meta.
 *
 * @param $data
 * @param bool $strict
 * @return bool
 */
function is_serialized( $data, $strict = true ): bool {
    // If it isn't a string, it isn't serialized.
    if ( ! is_string( $data ) ) {
        return false;
    }
    $data = trim( $data );
    if ( 'N;' === $data ) {
        return true;
    }
    if ( strlen( $data ) < 4 ) {
        return false;
    }
    if ( ':' !== $data[1] ) {
        return false;
    }
    if ( $strict ) {
        $lastc = substr( $data, -1 );
        if ( ';' !== $lastc && '}' !== $lastc ) {
            return false;
        }
    } else {
        $semicolon = strpos( $data, ';' );
        $brace     = strpos( $data, '}' );
        // Either ; or } must exist.
        if ( false === $semicolon && false === $brace ) {
            return false;
        }
        // But neither must be in the first X characters.
        if ( false !== $semicolon && $semicolon < 3 ) {
            return false;
        }
        if ( false !== $brace && $brace < 4 ) {
            return false;
        }
    }
    $token = $data[0];
    switch ( $token ) {
        case 's':
            if ( $strict ) {
                if ( '"' !== substr( $data, -2, 1 ) ) {
                    return false;
                }
            } elseif ( false === strpos( $data, '"' ) ) {
                return false;
            }
        // Or else fall through.
        case 'a':
        case 'O':
            return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
        case 'b':
        case 'i':
        case 'd':
            $end = $strict ? '$' : '';
            return (bool) preg_match( "/^{$token}:[0-9.E+-]+;$end/", $data );
    }
    return false;
}

/**
 * Returns true if the access is for generating/reading images through phpThumb.
 * @return bool
 */
function isPhpThumb() : bool {
    $_phpThumb = false;
    if ( isset($_SERVER['PHP_SELF']) ) {
        if ( strpos($_SERVER['PHP_SELF'], 'phpThumb.php') !== false ) $_phpThumb = true;
    }
    return $_phpThumb;
}


/**
 * Gets userIdx from two dimensional array and returns it in an array.
 *
 * Note that, it can collect not only `userIdx` but also any field by by specifying $field.
 *
 * @param $users
 * @param string $field
 * @return array
 *
 * @example
 *  ids([ ['idx'=>1, ...], [], ... ])
 */
function ids(array $users, string $field=IDX): array
{
    $ret = [];
    foreach ($users as $u) {
        $ret[] = $u[$field];
    }
    return $ret;
}

/**
 * To indicating testing.
 */
$_testing = false;
function isTesting(): bool {
    global $_testing;
    return $_testing;
}
function enableTesting() {
    global $_testing;
    $_testing = true;
}
function disableTesting() {
    global $_testing;
    $_testing = true;
}

/**
 * To indicating debugging range.
 * @example
enableDebugging();
post($post3[IDX])->vote('Y');
disableDebugging();
 */
$_debugging = false;
function isDebugging(): bool {
    global $_debugging;
    return $_debugging;
}
function enableDebugging() {
    global $_debugging;
    $_debugging = true;
}
function disableDebugging() {
    global $_debugging;
    $_debugging = false;
}


function select_list_widgets($categoryIdx,  $widget_type, $setting_name) {

    $default_selected = category($categoryIdx)->v($setting_name, $widget_type . '-default');



    echo "<select name='$setting_name' class='w-100'>";
    select_list_widgets_option($widget_type, $default_selected);
    echo "</select>";

}

function select_list_widgets_option($type, $default_selected) {
    foreach( glob(ROOT_DIR . "/widgets/$type/**/*.php") as $file ) {
        $info = parseDocBlock(file_get_contents($file));
        if ( isset($info['type']) && $info['type'] == 'admin' ) continue;

        $arr = explode('/', $file);
        array_pop($arr);
        $widget_folder_name = array_pop($arr);

        $description = isset($info['name']) ? $info['name'] : $widget_folder_name;


        $value = "$type/$widget_folder_name";
        if ( str_contains($value, $default_selected) ) $selected = "selected";
        else $selected = "";

        echo "<option value='$value' $selected>$description</option>";
    }
}


/**
 * Parses docblock. It's not perfect but useful.
 *
 * You can add some information/annotation in php comments.
 * It is used for reading widget information.
 *
 * @param $str
 * @return array|null
 *
 * @example
 *
 *
$str = '
 * @param  Okay. @ comes after space and *
@return Okay. @ comes after space
 * - @note Nope. @ is after -
Some content
@this This still works. As long as it comes after space or white.
/ **
 * @then This works.
 * /
';
d(parseDocBlock($str));
 */
function parseDocBlock($str) {
    if (preg_match_all('/^[\s\*]*@(\w+)\s+(.*)\r?\n/m', $str, $matches)) {
        $result = array_combine($matches[1], $matches[2]);
        return $result;
    }
    return null;
}





/**
 * Returns an array of user ids that are in the path(tree) of comment hierarchy.
 *
 * @note it does not include the login user and it does not have duplicated user id.
 *
 * @param $idx - comment idx
 *
 * @return array - array of user ids
 *
 * @attention  It will recursively read database records. Make it minimal.
 *
 * @todo move this method to `PostTaxonomy`
 */
function getCommentAncestors(int $idx): array
{
    $comment = comment($idx);
    $asc     = [];
    while (true) {
        $comment = comment($comment->parentIdx);
        if ( $comment->notFound ) break;
        if ($comment->userIdx == login()->idx) continue;
        $asc[] = $comment->userIdx;
    }
    $asc = array_unique($asc);
    return $asc;
}


/**
 * 1) get post owner id
 * 2) get comment ancestors users_id
 * 3) make it unique to eliminate duplicate
 * 4) get topic subscriber
 * 5) remove all subscriber from token users
 * 6) get users token
 * 7) send batch 500 is maximum
 *
 *  get all the user id of comment ancestors. - name as '$usersIdx'
 *  get all the user id of topic subscribers. - named as 'topic subscribers'.
 *  remove users of 'topic subscribers' from 'token users'. - with array_diff($array1, $array2) return the array1 that has no match from array2
 *  get the tokens of the users_id and filtering those who want to get comment notification
 *
 *
 * @param CommentTaxonomy|PostTaxonomy $cp
 * @throws Exception
 */
function onCommentCreateSendNotification(CommentTaxonomy|PostTaxonomy $cp)
{

    $post = post($cp->rootIdx);
    $usersIdx = [];

    /**
     * add post owner id if not mine
     */

    if ($post->isMine() == false) {
        $usersIdx[] = $post->userIdx;
    }

    /**
     * get comment ancestors id
     */
    if ($cp->parentIdx > 0) {
        $usersIdx = array_merge($usersIdx, getCommentAncestors($cp->idx));
    }

    /**
     * get unique user ids
     */
    $usersIdx = array_unique($usersIdx);

    /**
     * get user who subscribe to comment forum topic
     */
    $cat = category($cp->categoryIdx);
    $topic_subscribers = getForumSubscribers(NOTIFY_COMMENT . $cat->id);

    /**
     * remove users_id that are registered to comment topic. So, one user will not have two messages.
     */
    $usersIdx = array_diff($usersIdx, $topic_subscribers);

    /**
     * Get tokens of users that are not registered to forum comment topic and want to get notification on user settings
     */
    $tokens = getTokensFromUserIDs($usersIdx, NEW_COMMENT_ON_MY_POST_OR_COMMENT);


    /**
     * set the title and body, etc.
     */
    $title = login()->name . " Comment to " . $post->title;
    if (empty($title)) {
        if (isset($in[FILES]) && !empty($in[FILES])) {
            $title .= " uploaded photos post#" . $post->idx;
        }
    }

    // prepare message data.
    $body               = $cp->content;
    $click_url          = $cp->path;
    $data               = [
        'senderIdx' => login()->idx,
        'type' => 'post',
        'idx'=> $post->idx,
    ];

    /**
     * send notification to users who subscribe to comment topic
     */
    sendMessageToTopic(NOTIFY_COMMENT . $cat->id, $title, $body, $click_url, $data);

//    debug_log('tokens: ', $tokens);


    /**
     * send notification to comment ancestors who enable reaction notification
     */
    if (!empty($tokens)) sendMessageToTokens( $tokens, $title, $body, $click_url, $data);
}



/**
 * @param $topic - topic as string.
 *  It likes like `notificationPost_qna`.
 * @return array - array of user ids
 * @throws Exception
 */
function getForumSubscribers(string $topic): array
{
    return meta()->entities([CODE => $topic, DATA => ON], limit: 10000);
//    return getMetaEntities([CODE => $topic, DATA => ON], limit: 10000);
}


/**
 * 패스로그인 관련 라이브러리는 etc/callbacks/pass-login.lib.php 에 있다.
 * @param string $state
 * @return string
 */
function passLoginUrl($state = '')
{
    return "https://id.passlogin.com/oauth2/authorize?client_id=" . PASS_LOGIN_CLIENT_ID . "&redirect_uri=" . urlencode(PASS_LOGIN_CALLBACK_URL) . "&response_type=code&state=$state&prompt=select_account";
}


function inHome() {
    $p = in('p');
    return empty($p);
}


function displayWarning($msg): mixed {
    $root_domain = get_root_domain();
    echo <<<EOH
<div style="padding: 1em; border-radius: 16px; background-color: #ffc9c9;">
<div class="d-flex justify-content-between">
<div>알림</div>
<div>$root_domain</div>
</div>
<hr>
$msg
</div>
EOH;

    return '';

}


//////// next
function table(string $taxonomy): string {
    return DB_PREFIX . $taxonomy;
}

function separateByComma($str) {
    $rets = [];
    $str = trim($str);
    if ( $str ) {
        $parts = explode(",", $str);
        foreach( $parts as $part ) {
            $_part = trim($part);
            if ( empty($_part) ) continue;
            $rets[] = $_part;
        }
    }
    return $rets;
}

/**
 * 현재 글 idx 는 알고 있지만, 그 categoryIdx 는 모를 때 사용하는 함수이다.
 * @param $rootIdx
 * @return int
 */
function postCategoryIdx($rootIdx): int {
    return post()->column(CATEGORY_IDX, [IDX => $rootIdx]);
}
/**
 * category.idx 를 입력받아 category.id 를 리턴한다.
 * @param int $categoryIdx
 * @return int
 */
function postCategoryId(int $categoryIdx): string {
    return category()->column(ID, [IDX => $categoryIdx]);
}


/**
 * 키/값 배열을 입력 받아 SQL WHERE 조건문에 사용 할 문자열을 리턴한다.
 *
 * 예) [a => apple, b => banana] 로 입력되면, "a=apple AND b=banana" 로 리턴.
 *
 * 조건 식 사용법
 * 필드는 공백이 들어갈 수 없다는 점을 착안해서, 필드에 공백을 넣고, 다음에 조건식을 넣을 수 있도록 한다.
 *  - ['abc >' => 0] 과 같이 하면, "abc > 0" 으로 된다.
 *  - ['abc !=' => ''] 와 같이 하면 "abc != ''" 와 같이 된다.
 *
 * 값이 문자열이면 따옴표로 둘러싼다.
 *
 *
 * @param array $conds - 키/값을 가지는 배열
 * @param string $conj - 'AND' 또는 'OR' 등의 연결 expression
 * @param string $field - 이 파라메타에 값이 들어가면, $conds 에는 값만 들어간다. 즉, $field 를 필드로 해서, $conds 의 값을 사용해서 비교한다.
 *  예를 들어, 특정 필드에 여러 값 중 하나가 있는지 검사를 하기 위해서 사용 할 수 있다. 이 대, $field 에는 연산자를 지원하지 않는다.
 * @return string
 *
 * @example
 *  sqlCondition([a => apple, b => banana], $conj); // returns `a='apple' AND b='banana'`
 *  sqlCondition(['apple', 'banana'], 'OR', REASON); // returns `reason='apple' OR reason='banana'`
 *
 * @example tests/basic.sql.php
 */
function sqlCondition(array $conds, string $conj = 'AND', string $field = ''): string
{
    $arc = [];
    if ( $field ) {
        foreach( $conds as $v ) {
            if ( is_string($v) ) $v = "'$v'";
            $arc[] = "$field=$v";
        }
    } else {
        foreach($conds as $k => $v )  {
            $k = trim($k);
            if ( is_string($v) ) $v = "'$v'";
            if ( str_contains($k, ' ')) {
                $ke = explode(' ', $k, 2);
                $arc[] = "`$ke[0]` $ke[1] $v";
            }
            else {
                $arc[] = "`$k`=$v";
            }
        }
    }
    return implode(" $conj ", $arc);
}


/**
 * @deprecated use `js()`
 * Vue.js 를 한번만 로드한다.
 *
 * 참고로, 모든 자바스크립트 관련 코드는, 웹 브라우저로 전달되기 전에, 맨 하단으로 이동 될 수 있다.
 */
function includeVueJs() {
    if ( defined('VUE_JS') ) return;
    define('VUE_JS', true);

    $homeUrl = HOME_URL;
    if ( isLocalhost() ) {
        $url = "{$homeUrl}etc/js/vue.2.dev.js";
    } else {
        $url = "{$homeUrl}etc/js/vue-2.6.12-min.js";
    }
    echo "<script src='$url'></script>";
}

/**
 *
 * @example
 *  <?php js('/etc/js/chartjs-2/chart.bundle.min.js') ?>
 */
global $__js;
function js(string $src, int $priority=0) {
    global $__js;
    if ( isset($__js) == false || empty($__js) ) $__js = [];
    if ( $priority > 10 ) $priority = 10;
    $__js[$priority][] = $src;
}

/**
 * @return string
 */
function get_javascript_tags(string $scripts_and_styles): string {

    global $__js;
    if ( isset($__js) == false || empty($__js) ) return '';
    $ret = '';

    /// Get Javascript from priority 10 to 1.
    $compile = [];
    for($i=10; $i>=1; $i--) {
        if ( isset($__js[$i]) ) $compile = [ ...$compile, ...$__js[$i]];
    }
    $compile = array_unique($compile);
    foreach($compile as $src) {
        $ret .= "<script src=\"$src\"></script>\n";
    }

    /// Add captured scripts and styles.
    $ret .= $scripts_and_styles;

    // Get Javascripts for priority 0.
    if ( isset($__js[0]) ) {
        $compile = array_unique($__js[0]);
        foreach($compile as $src) {
            $ret .= "<script src=\"$src\"></script>\n";
        }
    }

    return $ret;
}

/**
 * Firebase 관련 Javascript 를 표시를 한다.
 *
 * 참고로, 모든 자바스크립트 관련 코드는, 웹 브라우저로 전달되기 전에, 맨 하단으로 이동 될 수 있다.
 */
function includeFirebase() {
    if ( defined('INCLUDE_FIREBASE') ) return;
    define('INCLUDE_FIREBASE', true);


    if ( defined('FIREBASE_SDK') ) echo FIREBASE_SDK;

}


/**
 * HTML FORM 에서 input 태그 중 hidden 으로 지정되는 값들 보다 편하게 하기 위한 함수.
 *
 * @param array $in
 *  이 값이 ['p', 'w'] 와 같이 입력되면, HTTP PARAM 의 키 p, w 와 그 값을 그대로 hidden tag 로 만든다.
 *  예) in:['p'] 와 같이 전달되면, <input type=hidden name=p value=in('p')> 와 같이 각 name 을 p 로 하고, in('p')  값을 채운다.
 * @param string $mode
 *  <input type=hidden name=mode value=...> 와 같이 form submit mode 를 지정한다.
 * @param array $kvs
 *  추적으로 지정할 name 과 value 를 지정한다.
 *  예) hiddens(kvs: ['p' => 'user.profile.submit']) 와 같이 호출하면, 아래와 같이 된다.
 *
 *      <input type='hidden' name='p' value='user.profile.submit'>
 *
 * @param string $p FORM 값을 넘길 페이지.
 * @param string $return_url 돌아갈 URL 지정
 *
 *
 * @return string
 *
 * 호출 예)
 *  hiddens(in: ['p', 'w', 's'], mode: 'submit', kvs: ['idx' => $post->idx])
 *
 * 리턴 값 예)
 *  <input type='hidden' name='mode' value='submit'>
 *  <input type='hidden' name='p' value='admin.index'>
 *  <input type='hidden' name='w' value='shopping-mall/admin-shopping-mall'>
 *  <input type='hidden' name='s' value='edit'>
 *  <input type='hidden' name='idx' value='0'>
 */
function hiddens(array $in=[], string $mode='', array $kvs=[], string $p="", string $return_url=""): string {
    $str = '';
    if ( $p ) {
        $str .= "<input type='hidden' name='p' value='$p'>\n";
    }
    if ( $mode ) {
        $str .= "<input type='hidden' name='mode' value='$mode'>\n";
    }
    if ( $in ) {
        foreach( $in as $k ) {
            $str .= "<input type='hidden' name='$k' value='".in($k)."'>\n";
        }
    }
    if ( $kvs ) {
        foreach( $kvs as $k => $v ) {
            $str .= "<input type='hidden' name='$k' value='$v'>\n";
        }
    }
    if ( $return_url ) {
        $str .= "<input type='hidden' name='".RETURN_URL."' value='$return_url'>\n";
    }
    return $str;
}


function short_date_time($stamp)
{
    $Y = date('Y', $stamp);
    $m = date('m', $stamp);
    $d = date('d', $stamp);
    if ($Y == date('Y') && $m == date('m') && $d == date('d')) {
        $dt = date("h:i a", $stamp);
    } else {
        $dt = "$Y-$m-$d";
    }
    return $dt;
}


/**
 * file.idx 를 입력 받아, 썸네일 URL 을 리턴한다.
 *
 * @param int $fileIdx
 * @param int $width
 * @param int $height
 * @param int $quality
 * @return string
 */
function thumbnailUrl(int $fileIdx, int $width=200, int $height=200, int $quality=200): string
{
    if ( empty($fileIdx) ) return '';
    return HOME_URL . "etc/phpThumb/phpThumb.php?src=$fileIdx&w=$width&h=$height&f=jpeg&q=$quality";
}


/**
 * 실명 인증을 한 사용자인지 확인을 한다.
 * CenterX 는 한국 시스템에 특화된 것으로, 패스 로그인을 했으면 실명 인증한 것으로 한다.
 * @return bool
 */
function isRealNameAuthUser(): bool {
    return !login()->v('plid');
}


/**
 * Custom error handling 을 할 수 있는 상황이면, true 를 리턴한다.
 * @return bool
 */
function canHandleError(): bool {
    return !API_CALL && !isCli() && !isPhpThumb();
}

/**
 * @param $errno
 * @param $errstr
 * @param $error_file
 * @param $error_line
 */
function customErrorHandler($errno, $errstr, $error_file, $error_line) {
    $APP_NAME = APP_NAME;
    echo <<<EOE
<div style="margin-bottom: 8px; padding: 16px; border-radius: 10px; background-color: #5a3764; color: white;">
    <div>{$APP_NAME} Error</div>
    <div style="margin-top: 16px; padding: 16px; border-radius: 10px; background-color: white; color: black;">
        <b>Error:</b> [$errno] $errstr in $error_file at line $error_line
    </div>
</div>
EOE;
    d(debug_backtrace());
}


/**
 * $content 에서 style 과 script 를 추철하여 리턴한다. 이 때, $content 는 call by reference 로 전달되어서 원래 변수에서도 삭제된다.
 *
 * @param string $content
 * @return string
 */
function capture_styles_and_scripts(string &$content)
{
    $res = '';

    $pos = stripos($content, "<body"); // <body ...> 와 같이 속성이 들어 갈 수 있음.
    $before = substr($content, 0, $pos);
    $after = substr($content, $pos);


    /// Get javascript
    /// 자바스크립트가 <script src=...></script> 와 같이 되면, 아래의 + 옵션에 맞지 않으므로, 추출되지 않는다.
    /// 즉, <script src=...> 와 같이 외부 import 는 하단으로 이동되지 않는다.
    $re = preg_match_all('/\<script(.*?)?\>(.|\s)+?\<\/script\>/i', $after, $m);
    if ($re) {
        $scripts = $m[0];
        foreach ($scripts as $script) {
            $after = str_replace($script, '', $after);
        }
        $res .= implode("\n", $scripts);
    }


    /// Get styles

    $re = preg_match_all("/\<style\>[^(\<)]*\<\/style\>/s", $after, $m);
    if ($re) {
        $styles = $m[0];
        foreach ($styles as $style) {
            $after = str_replace($style, '', $after);
        }
        $res .= implode("\n", $styles);
    }

    $content = $before . $after;

    return $res;
}

/**
 * @param bool $question
 * @return string
 */
function lsub(bool $question=false): string {
    if ( !in('lsub') ) return '';
    if ( $question ) return "?lsub=" . in('lsub');
    else return "&lsub=" . in('lsub');
}
function inLsub(bool $question=false) { return lsub($question); }
function inCategoryId(bool $question=false) {
    if ( !in('categoryId') ) return '';
    if ( $question ) return "?categoryId=" . in('categoryId');
    else return "&categoryId=" . in('categoryId');
}
function inSubcategory(bool $question=false) {
    if ( !in('subcategroy') ) return '';
    if ( $question ) return "?subcategroy=" . in('subcategroy');
    else return "&subcategroy=" . in('subcategroy');
}


