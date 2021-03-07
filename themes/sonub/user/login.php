<?php
    if ( in('mode') == 'register' ) {
        displayWarning('회원 가입이 따로 없으며, 아래와 같이 로그인을 하시면 됩니다.');
    }
?>


<div class="box">

    <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>">패스 휴대폰번호 로그인</a>

    <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>">카카오톡 로그인</a>

    <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>">네이버 로그인</a>

</div>


<?php
include_once widget('login/social-login');

