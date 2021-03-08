<?php
define('API_CALL', in(ROUTE) != null);


live_reload();

/**
 * @param $errno
 * @param $errstr
 * @param $error_file
 * @param $error_line
 */
function customErrorHandler($errno, $errstr, $error_file, $error_line) {
    if ( strpos($errstr, 'metas') && strpos($errstr, "doesn't exist") ) {
        jsGo('/etc/install/install.php');
        return;
    }
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


// set error handler
if ( canHandleError() ) {
    set_error_handler("customErrorHandler");
}

use ezsql\Database;
$__db = Database::initialize('mysqli', [DB_USER, DB_PASS, DB_NAME, DB_HOST]);

/**
 * db() 는 db 에 두 번 접속하지 않도록, 생성된 객체를 리턴한다.
 * @return Database\ez_mysqli|Database\ez_pdo|Database\ez_pgsql|Database\ez_sqlite3|Database\ez_sqlsrv|false
 */
function db() {
    global $__db;
    return $__db;
}


/**
 * 아래의 코드는 config 테이블이 존재하는지 하지 않는지 확인을 하기 위한 것이다. 존재하지 않으면 customErrorHandlerHandler 에 의해서 설치 페이지로 넘어간다.
 */
$installedAt = config()->get('installation check');




debug_log('-- start -- boot.code.php: ', date('r'));
debug_log('in();', in());

if ( API_CALL == false ) {
    setUserAsLogin(getProfileFromCookieSessionId());
}







