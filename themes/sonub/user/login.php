<?php
    if ( in('mode') == 'register' ) {
        displayWarning('회원 가입이 따로 없으며, 아래와 같이 로그인을 하시면 됩니다.');
    }
?>


<?php
include_once widget('login/email-password');
include_once widget('login/social-login');

