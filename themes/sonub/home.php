<?php

?>


<?php if ( loggedIn() ) { ?>
    어서오세요, <?=my(NAME)?>님.
<?php } else { ?>
<?php } ?>
    <div class="m-5">
        <a class="btn btn-primary" href="/?p=user.register">회원 가입</a>
        <a class="btn btn-primary" href="/?p=user.login">로그인</a>
        <a class="btn btn-primary" href="/?p=user.profile">회원 정보</a>
        <a class="btn btn-primary" href="/?p=user.logout.submit">로그아웃</a>
    </div>

<?php

d( login()->profile() );






