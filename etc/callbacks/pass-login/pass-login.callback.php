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


    <title>패스 로그인</title>
    <style>
        .fs-lg { font-size: 1.25rem; }
	.mt-5 { margin-top: 2rem; }
	.pt-5 { padding-top: 2rem; }

    </style>
</head>
<body>

<?php
require_once('pass-login.lib.php');
require_once('pass-login.verify.php');
?>
<div class="mt-5 pt-5 d-flex justify-content-center w-100">
    <div class="mt-5 text-center">
        <div class="mt-3">로그인 성공</div>
        <div class="mt-5" style="font-size: 1rem;">
           브라우저를 닫아주세요.
        </div>
    </div>
</div>
<script>
location.href= "https://<?=in('state')?>";
</script>


</body>
</html>
