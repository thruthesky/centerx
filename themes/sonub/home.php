<?php




?>



    <h1>Home</h1>

<?php if ( loggedIn() ) { ?>
    어서오세요, <?=my(NAME)?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>
    <div class="m-5">
        <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>"><?=ln(['en' => 'Pass Login', 'ko' => '패스 로그인'])?></a>
        <a class="btn btn-primary" href="/?p=user.register"><?=ln(['en' => 'Register', 'ko' => '회원 가입'])?></a>
        <a class="btn btn-primary" href="/?p=user.login"><?=ln(['en' => 'Login', 'ko' => '로그인'])?></a>
        <a class="btn btn-primary" href="/?p=user.profile"><?=ln(['en' => 'Profile', 'ko' => '회원 정보'])?></a>
        <a class="btn btn-primary" href="/?p=user.logout.submit"><?=ln(['en' => 'Logout', 'ko' => '로그아웃'])?></a>
        <a class="btn btn-primary" href="/?p=forum.post.list&categoryId=qna">QnA</a>

        <?php if ( admin() ) { ?>
            <a class="btn btn-primary" href="/?p=admin.index"><?=ln(['en' => 'Admin', 'ko' => '관리자'])?></a>
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

<hr>
이전 버전에서는 너무 크게 계획을 잡았다. 위젯 관리라든지, 기타 등등을 할 수 없도록 한다. 게시판도 모두 동일한 게시판을 쓴다.
    필고와 거의 비슷한 디자인을 쓰는데, 로고 변경 할 수 있도록 하고,
필고 메인 메뉴에 노란색 메뉴 처럼, 앞 5개 메뉴를 직접 만들어 쓸 수 있도록 한다.
관리자로 직접 지정하며, 글 쓰기/수정/삭제를 할 수 있다.
<hr>
이번 버전에서는 최소로 한다.
<hr>
카카오, 네이버로 접속하면, 장터 게시판에 글 등록할 수 있도록만 한다.
<?php


