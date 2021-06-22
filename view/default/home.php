<?php



?>

    <h1>Default Theme</h1>
<?php
echo date('r', time()) . '<hr>';
echo date('r', 1624287600) . '<hr>';
echo date('r', 1624374000);
?>
<?php if ( loggedIn() ) { ?>
    어서오세요, <?=login()->name?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>
    <div class="m-5">
        <?php if ( notLoggedIn() ) { ?>
            <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>"><?=ln(['en' => 'Pass Login', 'ko' => '패스 로그인'])?></a>
            <a class="btn btn-primary" data-cy="register-button" href="/?p=user.register"><?=ln(['en' => 'Register', 'ko' => '회원 가입'])?></a>
            <a class="btn btn-primary" data-cy="login-button" href="/?p=user.login"><?=ln(['en' => 'Login', 'ko' => '로그인'])?></a>
        <?php } else { ?>
            <a class="btn btn-primary" href="/?p=user.profile"><?=ln(['en' => 'Profile', 'ko' => '회원 정보'])?></a>
            <a data-cy="logout-button" class="btn btn-primary" href="/?p=user.logout.submit"><?=ln(['en' => 'Logout', 'ko' => '로그아웃'])?></a>
        <?php } ?>

        <a class="btn btn-primary" href="/?p=forum.post.list&categoryId=qna">QnA</a>
        <a class="btn btn-primary" href="/?p=forum.post.list&categoryId=discussion">Discussion</a>
        <a class="btn btn-primary" href="/?p=forum.post.list&categoryId=reminder">Reminder</a>

        <?php if ( admin() ) { ?>
            <a data-cy="home-admin-button" class="btn btn-primary" href="/?p=admin.index"><?=ln(['en' => 'Admin', 'ko' => '관리자'])?></a>
        <?php } ?>
        <form action="/">
            <input type="hidden" name="p" value="setting.language.submit">
            <select name="language" onchange="this.form.submit()">
                <option value="">Choose language</option>
                <?php foreach( SUPPORTED_LANGUAGES as $ln ) { ?>
                    <option value="<?=$ln?>"><?=ln($ln, $ln)?></option>
                <?php } ?>
            </select>
        </form>
    </div>


<?php


d($_COOKIE);

d(login()->profile());

