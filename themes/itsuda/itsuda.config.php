<?php


define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", ROOT_DIR . "etc/keys/itsuda50-firebase-adminsdk.json");
define("FIREBASE_DATABASE_URI", "https://itsuda50-default-rtdb.firebaseio.com/");

if ( !defined('PASS_LOGIN_CLIENT_ID') ) define('PASS_LOGIN_CLIENT_ID', 'zmYolgOxhrb3hvsUIvl4');
if ( !defined('PASS_LOGIN_CLIENT_SECRET_KEY') ) define('PASS_LOGIN_CLIENT_SECRET_KEY', 'b4f0da22352d2c5d885a6f626654627838ab6ad8103d37e0d979d26cb46fff26');
if ( !defined('PASS_LOGIN_CALLBACK_URL') ) define('PASS_LOGIN_CALLBACK_URL', "https://itsuda50.com/wp-content/themes/sonub/callbacks/pass-login.callback.php");






routeAdd('app.version', function($in) {
    return ['version' => 'app version 12345 !!!'];
});



