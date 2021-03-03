<?php


$profile = user()->login([EMAIL => in(EMAIL), PASSWORD => in(PASSWORD)]);
if ( e($profile)->isError ) echo "ERROR: $profile";
else {
    setLoginCookies($profile);
    jsGo('/');
}