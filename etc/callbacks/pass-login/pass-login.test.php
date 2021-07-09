<?php

require_once('../../../boot.php');
$domain = $_SERVER['HTTP_HOST'];
$redirectUrl = urlencode(PASS_LOGIN_CALLBACK_URL);

$url = "https://id.passlogin.com/oauth2/authorize?response_type=code&client_id=".PASS_LOGIN_CLIENT_ID . "&redirect_uri$redirectUrl&state=$domain&prompt=N&isHybrid=N";
?>


<h1>패스 로그인 테스트</h1>
<a href="<?=$url?>">로그인 클릭 <?=$url?></a>