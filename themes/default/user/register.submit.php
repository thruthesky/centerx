<?php

$idx = user()->register(in());
if ( isError($idx) ) jsAlert($idx);
else {

    setLoginCookies($idx);
//    jsGo('/');
}