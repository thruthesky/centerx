<?php

$user = user()->login([EMAIL => in(EMAIL), PASSWORD => in(PASSWORD)]);
if ( $user->hasError ) echo "ERROR: " . $user->getError();
else {
//    echo "
//    <script>
//        saveToken(localStorage.getItem('pushToken'), location.hostname);
//    </script>
//    ";
    setLoginCookies($user->profile());
    jsGo('/');
}