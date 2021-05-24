<?php

$user = user()->login([EMAIL => in(EMAIL), PASSWORD => in(PASSWORD)]);
if ( $user->hasError ) echo "ERROR: " . $user->getError();
else {
    setLoginCookies($user->profile());
    jsGo('/?mode=loggedIn');
}