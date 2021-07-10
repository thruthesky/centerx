<?php
/**
 * @file pass-login-callback.php
 * @desc
 */
/// README.md 의 테스트 하는 방법 참고
require_once('../../../boot.php');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>패스 로그인</title>
    <style>
        .fs-lg { font-size: 1.25rem; }
	.mt-5 { margin-top: 2rem; }
	.pt-5 { padding-top: 2rem; }
    .text-center {
        text-align: center;
    }

    </style>
</head>
<body>

<?php
require_once('pass-login.lib.php');
require_once('pass-login.verify.php');
?>
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
//location.href= "https://<?//=$domain?>///passlogin/success";
</script>


</body>
</html>
