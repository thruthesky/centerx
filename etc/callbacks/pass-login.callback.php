<?php
/**
 * @file pass-login-callback.php
 * @desc
 */



require_once('../../boot.php');
require_once('pass-login.lib.php');



// 인증
$user = pass_login_callback($_REQUEST);
if ( isError($user) ) {
    pass_login_message($user);
    exit;
}
//debug_log("pass-login-callback.php:: user", $user);/


/**
 * 인증 성공 했을 때, 넘어오는 값 예)
 * - 아래의 값으로 실제 테스트 가능. 위 코드를 주석 처리하고, 아래 부터 테스트 가능.
 */
//$user = [
//    'ci' => 'fkxZh3dlJtMa9u+Prs42nkY4IoTUOw9J65gWlVYNpjsZ3psXHJGamA6olV9uW46l9Lge0D36xQkCBN9q5lmuZA==',
//    'phoneNo' => '01086934225',
//    'name' => '송재호',
//    'birthdate' => 731016,
//    'gender' => 'M',
//    'agegroup' => 40,
//    'foreign' => 'L',
//    'telcoCd' => 'S',
//    'plid' => '86289de3-aa03-468f-a7ef-0526fc33a219',
//    'autoStatusCheck' => 'N',
//];

$profile = pass_login_or_register($user);

if ( isError($profile) ) {
//    debug_log("pass-login-callback-php:: error code: $profile");
    echo "<h1>ERROR: $profile</h1>";
    exit;
}
/**
 * 여기까지 오면 로그인 성공
 */

/**
 * state 가 openHome 이면, 홈페이지로 이동
 */
if ( $_REQUEST['state'] === 'openHome' ) {

//    debug_log("pass-login-callback.php:: profile", $profile);
    setLoginCookies( $profile );
    jsGo('/');
}

/**
 * 자바스크립트로 메시지 전송
 */
$json = json_encode($profile);
echo <<<EOJ
<script>
    messageHandler.postMessage('$json');
</script>
EOJ;
?>

<?php
//    pass_login_message('로그인 성공');
?>

