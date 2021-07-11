<?php
/**
 * @file pass-login-callback.php
 * @desc
 */

//Minimize caching so admin area always displays latest statistics

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");

/// README.md 의 테스트 하는 방법 참고
require_once('../../../boot.php');
debug_log('pass-login-callback.php -- boot');
require_once('pass-login.lib.php');
require_once('pass-login.verify.php');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="cache-control" content="max-age=0" />
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">

    <title>패스 로그인</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Malgun Gothic", "맑은 고딕", helvetica, "Apple SD Gothic Neo", sans-serif;
        }
        .fs-lg { font-size: 1.25rem; }
	.mt-5 { margin-top: 2rem; }
	.pt-5 { padding-top: 2rem; }
    .text-center {
        text-align: center;
    }

    </style>
</head>
<body>

<div class="mt-5 pt-5">
    <div class="mt-5 text-center">
        <h1 class="mt-3">로그인 성공</h1>
        <div class="mt-5" style="font-size: 1rem;">
           브라우저를 닫고 홈페이지로 접속해 주세요.
        </div>
    </div>
</div>

<script>
    <?php
        $domain = in('state', $_SERVER['HTTP_HOST']);
        ?>

    setTimeout(function() {
        location.href= "https://<?=$domain?>/passlogin/success";
    }, 1000);
</script>

<?php
d(in());
?>

</body>
</html>
