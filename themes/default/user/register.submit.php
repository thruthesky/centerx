<?php

$user = user()->register(in());
if ( $user->hasError ) jsAlert($user->getError());
else {
    setLoginCookies($user->profile());
    jsGo('/');
}