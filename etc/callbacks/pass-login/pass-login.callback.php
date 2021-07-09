<?php
/**
 * @file pass-login-callback.php
 * @desc
 */

require_once('../../../boot.php');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>소너브 패스 로그인</title>
    <style>
        .fs-lg { font-size: 1.25rem; }
    </style>
</head>
<body>

<?php
require_once('pass-login.lib.php');
require_once('pass-login.verify.php');
?>
<div class="mt-5 pt-5 d-flex justify-content-center w-100">
    <div class="mt-5 text-center">
        <h1>소너브</h1>
        <div class="mt-3">로그인 성공</div>
        <div class="mt-5" style="font-size: 1rem;">
           브라우저를 닫아고 다시 접속해주세요.
접속 도메인: <?=in('state')?>
        </div>
    </div>
</div>


</body>
</html>
