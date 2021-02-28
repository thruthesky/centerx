<?php

$idx = user()->register(in());
if ( isError($idx) ) jsBack($idx);
setLoginCookies($idx);
jsGo('/');