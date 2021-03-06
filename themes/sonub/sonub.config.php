<?php

define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", ROOT_DIR . "/keys/sonub-firebase-adminsdk.json");
define("FIREBASE_DATABASE_URI", "https://sonub-version-2020.firebaseio.com/");



/**
 * 레이아웃 너비
 */
define('L_CONTENT', 1024);
define('L_LEFT', 260);
define('L_RIGHT', 260);

define('L_CENTER', inHome() ?
    L_CONTENT - L_LEFT - L_RIGHT :
    L_CONTENT - L_LEFT
);
