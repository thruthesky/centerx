<?php

$user = user()->register(in());
if ( $user->hasError ) jsAlert($user->getError());
else {
//    ?>
<!--    <script>-->
<!--        saveToken(localStorage.getItem('pushToken'), location.hostname);-->
<!--    </script>-->
<!--    --><?php
    setLoginCookies($user->profile());
    jsGo('/');
}