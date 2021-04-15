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

$profile = pass_login_or_register($user);

if ( isError($profile) ) {
//    debug_log("pass-login-callback-php:: error code: $profile");
    echo "<h1>ERROR: $profile</h1>";
    exit;
}
/**
 * 여기까지 오면 로그인 성공
 */
?>
<?php includeFirebase(); ?>
<script>
const db = firebase.firestore();
db.collection('notifications').doc('<?=in('state')?>').set({time: (new Date).getTime(), sessionId: '<?=$profile['sessionId']?>'});
</script>