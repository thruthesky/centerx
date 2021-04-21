<?php
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
 * 여기까지 오면 로그인 성공. DB 에 기록을 남기고, Firestore 에 기록을 남긴다.
 * DB 에 기록을 남기는 이유는 Flutter 에서 In-app-browser 를 종료하면, 곧 바로 서버에 접속해서, 로그인 정보를 가져오기 위해서이다.
 * 참고로, Firestore 와 통신이 안되는 경우가 있는 것 같다.
 */
user($profile[IDX])->update([in('state') => $profile[SESSION_ID]]);
?>
<?php includeFirebase(); ?>
<script>
    const db = firebase.firestore();
    db.collection('passlogin').doc('<?=in('state')?>')
        .set({time: (new Date).getTime(), sessionId: '<?=$profile['sessionId']?>'})
    ;
</script>
