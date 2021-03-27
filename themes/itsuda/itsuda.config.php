<?php


define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", ROOT_DIR . "etc/keys/itsuda50-firebase-adminsdk.json");
define("FIREBASE_DATABASE_URI", "https://itsuda50-default-rtdb.firebaseio.com/");

define('PASS_LOGIN_CLIENT_ID', 'zmYolgOxhrb3hvsUIvl4');
define('PASS_LOGIN_CLIENT_SECRET_KEY', 'b4f0da22352d2c5d885a6f626654627838ab6ad8103d37e0d979d26cb46fff26');
define('PASS_LOGIN_CALLBACK_URL', isLocalhost() ?
    "https://local.itsuda50.com/etc/callbacks/pass-login.callback.php" :
    "https://itsuda50.com/etc/callbacks/pass-login.callback.php"
);


define('FIX_LANGUAGE', 'ko');


define('HEALTH_CATEGORIES', [
    'health_meal_morning',
    'health_meal_lunch',
    'health_meal_dinner',
    'health_scribble',
    'health_exercise',
    'health_sleep',
    'health_brain'
]);


include 'itsuda.hooks.php';
include 'itsuda.route.php';





routeAdd('app.version', function($in) {
    return ['version' => 'itsuda 0.2'];
});





