<?php
//define('UPLOAD_SERVER_URL', 'https://main.sonub.com/');


if ( !defined('NAVER_CLIENT_ID') ) define('NAVER_CLIENT_ID', 'uCSRMmdn9Neo98iSpduh');
if ( !defined('NAVER_CLIENT_SECRET') ) define('NAVER_CLIENT_SECRET', 'lmEXnwDKAD');
if ( !defined('NAVER_CALLBACK_URL') ) define('NAVER_CALLBACK_URL', urlencode('https://main.philov.com/etc/callbacks/naver/naver-login.callback.php'));
if ( !defined('NAVER_API_URL') ) define('NAVER_API_URL', "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_ID."&redirect_uri=".NAVER_CALLBACK_URL."&state=1");

