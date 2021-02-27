<?php


$profile = user()->login(in());
if ( error($profile)->isError ) echo "ERROR: $profile";

setLoginCookies($profile);
jsGo('/');