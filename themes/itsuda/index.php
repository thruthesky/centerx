<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .top { top: 0; }
        .left { left: 0; }
        .fs-lg { font-size: 2rem; }
        .fs-title { font-size: 1.2rem; }
        .fs-desc { font-size: 0.85rem; color: #676565; }
        .hint { font-size: 0.8rem; color: #626963; }
        .em { color: darkred; font-weight: bold; }
        .border-radius-md { border-radius: 16px; }
        .opacity-0 { opacity: 0; }
        .w-200px { width: 200px; }
    </style>
    <script>
        function later(fn) { window.addEventListener('load', fn); }
    </script>
</head>
<body>

<?php if ( str_contains(theme()->page(), '/admin/') ) { ?>
    <?php include theme()->page(); ?>
<?php } else { ?>
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                <div class="d-block w-200px">
                    <a href="/"><img class="py-3 pl-5 w-100" src="themes/itsuda/img/logo.jpg"></a>
                </div>
            </div>
            <div class="mt-4">
                <a class="p-2" style="font-size: 1rem" href="/">다운로드</a>
                <?php if ( loggedIn() ) { ?>
                    <a class="p-2" style="font-size: 1.1rem" href="/?admin.index"><?=login()->name?>(<?=login()->idx?>)</a>
                    <a class="p-2" style="font-size: 1.1rem" href="/?user.logout.submit"><?=ln(['en' => 'Logout', 'ko' => '로그아웃'])?></a>
                <?php } else { ?>
                    <a class="p-2" style="font-size: 1.1rem" href="/?user.login"><?=ln(['en' => 'Login', 'ko' => '로그인'])?></a>
                <?php } ?>

                <a class="p-2" style="font-size: 1.1rem" href="/?p=forum.post.list&categoryId=qna"><?=ln(['en' => 'QnA', 'ko' => '질문게시판'])?></a>
                <a class="p-2" style="font-size: 1.1rem" href="/?p=forum.post.list&categoryId=discussion"><?=ln(['en' => 'Discussion', 'ko' => '자유게시판'])?></a>
            </div>
        </div>
    </div>
    <div class="container">
        <?php
        include theme()->page();
        ?>
    </div>
<?php } ?>

<script src="<?=HOME_URL?>etc/js/helper.js?v=2"></script>
</body>
</html>