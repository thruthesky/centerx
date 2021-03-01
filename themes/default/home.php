<?php




?>

<h1>Home</h1>

<?php if ( loggedIn() ) { ?>
    어서오세요, <?=my(NAME)?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>
    <div class="m-5">
        <a class="btn btn-primary" href="/?p=user.register">회원 가입</a>
        <a class="btn btn-primary" href="/?p=user.login">로그인</a>
        <a class="btn btn-primary" href="/?p=user.profile">회원 정보</a>
        <a class="btn btn-primary" href="/?p=user.logout.submit">로그아웃</a>

        <?php if ( admin() ) { ?>
            <a class="btn btn-primary" href="/?p=admin.user.list">관리자</a>
        <?php } ?>
    </div>


<?php


d(post()->getFromPath());






d( login()->profile() );






