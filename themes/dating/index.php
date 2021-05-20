<!doctype html>
<html lang="en">
<head>
    <title>만남사이트</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/etc/bootstrap-4/bootstrap-4.6.0-min.css">
    <link rel="stylesheet" href="/etc/bootstrap-vue-2.21.2/bootstrap-vue-2.21.2.min.css">
    <link href="/etc/fontawesome-pro-5/css/all.min.css" rel="stylesheet">
    <link href="/themes/dating/style.css" rel="stylesheet">
    <script>
        <?php include theme()->file('js/prepare', extension: 'js'); ?>
    </script>
</head>
<body>
<section id="app">
    <header class="bg-light mb-2">
        <div class="container text-center">
            <a href="/">홈</a>
            <?php if(loggedIn()) { ?>
            <a href="?user.logout.submit">로그아웃</a>
            <?php } else { ?>
            <a href="?user.login">로그인</a>
            <a href="?user.register">회원가입</a>
            <?php }  ?>

            <a href="?forum.post.list">자유게시판</a>
            <a href="#">질문게시판</a>
        </div>
    </header>
    <div class="row">
        <div class=" col-lg-3 bg-warning">left</div>
        <div class=" col-lg-6 bg-light"><?php include theme()->page(); ?></div>
        <div class=" col-lg-3 bg-dark">right</div>
    </div>
    <footer class="bg-success mt-5">
        <div class="text-center">
            (C) 2021. All Right Reserved by Withcenter, Inc.
        </div>
    </footer>
</section>

<!-- Load polyfills to support older browsers before loading Vue and Bootstrap Vue -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver%2CObject.fromEntries"
        crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/common.js', 7) ?>
<?php js(HOME_URL . 'etc/js/vue.2.6.12.min.js', 2) ?>
<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 1) ?>
<?php js(theme()->url . 'js/data.js', 1) ?>
<?php js(theme()->url . 'js/app.js', 0) ?>
</body>
</html>
