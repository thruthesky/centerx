<?php
    $user = user()->register(in());
    if ( $user->hasError ) {
        echo $user->getError();
        exit;
    } else {
        setLoginCookies($user->profile());
    }
?>
<script>
    location.href='/';
</script>