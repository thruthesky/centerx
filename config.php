<?php

define('DOMAIN_THEMES', [
    'philov' => 'sonub',
    'tellvi' => 'sonub',
    'sonub' => 'sonub',
    'goldenage50' => 'itsuda',
    'itsuda' => 'itsuda'
]);


/**
 * 각 테마별 설정 파일이 있으면 그 설정 파일을 사용한다.
 *
 * 참고로, 각 설정 파일에서 아래에서 정의되는 상수들을 미리 정의해서, 본 설정 파일에서 정의되는 값을 덮어 쓸 수 있다.
 */
$_path = theme()->file( filename: 'config.php', prefixThemeName: true );
if ( file_exists($_path) ) {
    require_once $_path;
}




define('DB_USER', 'myuser');
define('DB_PASS', 'mypass');
define('DB_NAME', 'mydatabase');
define('DB_HOST', 'mariadb');


