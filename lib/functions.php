<?php

function d($obj) {
    echo "<xmp>";
    print_r($obj);
    echo "</xmp>";
}


/**
 * @return bool
 */
function is_cli(): bool
{
    return php_sapi_name() == 'cli';
}


/**
 * Returns true if the web is running on localhost (or developers computer).
 * @return bool
 */
function is_localhost(): bool
{

    if (is_cli()) return false;
    $localhost = false;
    $ip = $_SERVER['SERVER_ADDR'];
//    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || PHP_OS === 'Darwin') $localhost = true;
//    else {

        if (strpos($ip, '127.0.') !== false) $localhost = true;
        else if (strpos($ip, '192.168.') !== false) $localhost = true;
        else if ( strpos($ip, '172.') !== false ) $localhost = true;
//    }
    return $localhost;
}



function live_reload_js()
{
    /// TODO print this only for localhost(local dev)
    if ( is_localhost() )
        echo <<<EOH
   <script src="https://main.philov.com:12345/socket.io/socket.io.js"></script>
   <script>
       var socket = io('https://main.philov.com:12345');
       socket.on('reload', function (data) {
           console.log(data);
           // window.location.reload(true);
           location.reload();
       });
   </script>
EOH;
}



/**
 * 도메인을 리턴한다.
 * 예) www.abc.com, second.host.abc.com
 * Returns requested url domain
 * @return string
 */
function get_host_name(): string
{
    if (isset($_SERVER['HTTP_HOST'])) return $_SERVER['HTTP_HOST'];
    else return '';
}


/**
 * Alias of get_host_name()
 * @return string
 */
function get_domain() : string
{
    return get_host_name();
}
/**
 * Alias of get_host_name()
 * @return string
 */
function get_domain_name(): string
{
    return get_host_name();
}

