<!doctype html>
<html lang="en">
<head>
    <title>만남사이트</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/etc/bootstrap-4/bootstrap-4.6.0-min.css">
    <link rel="stylesheet" href="/etc/bootstrap-vue-2.21.2/bootstrap-vue-2.21.2.min.css">
    <link href="/etc/fontawesome-pro-5/css/all.min.css" rel="stylesheet">
    <script>
        <?php include theme()->file('js/prepare', extension: 'js'); ?>
    </script>
</head>
<body>
<section id="app">
    <header class="text-center">
        <?php d($_COOKIE)?>
        <h1>만남 사이트</h1>
        어서오세요, <?=login()->idx?>님,
        <a href="/">홈</a>
        <a href="/?user.register">회원 가입</a>
        <a href="/?p=user.logout.submit">로그아웃</a>
        <a href="/?user.login">로그인</a>
        <a href="/?user.profile">회원 정보</a>
        |
        <a href="/?forum.post.list&categoryId=qna">질문게시판</a>
        <a href="/?forum.post.list&categoryId=discussion">자유게시판</a>
    </header>
    <div class="container-xl bg-light">
        <div class="row">
            <div class="d-none d-md-block col-4 col-lg-3 bg-light">Left</div>
            <div class="col-12 col-md-8 col-lg-6 p-0 m-0"><?php include theme()->page();?></div>
            <div class="d-none d-lg-block col-3 bg-light">Right</div>
        </div>
    </div>
    <footer class="mt-5">
        <div class="text-center">
            (C) 2021. All Right Reserved by Withcenter, Inc.
        </div>
    </footer>
</section>
<!-- Load polyfills to support older browsers before loading Vue and Bootstrap Vue -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver%2CObject.fromEntries" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/helper.js', 7)?>
<?php js(HOME_URL . 'etc/js/vue.2.6.12.min.js', 2)?>
<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 1)?>
<?php js(theme()->url . 'js/data.js', 1)?>
<?php js(theme()->url . 'js/app.js', 0)?>
</body>
</html>
