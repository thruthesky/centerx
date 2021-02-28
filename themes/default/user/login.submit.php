<?php


$profile = user()->login(in(EMAIL), in(PASSWORD));
if ( e($profile)->isError ) echo "ERROR: $profile";
else {

    setLoginCookies($profile);
    jsGo('/');
}