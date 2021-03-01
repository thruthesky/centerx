<?php
/**
 * @file index.php
 */
/**
 * Preflight
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    echo ''; // No return data for preflight.
    exit;
}



$func = str_replace('.', '_', in('route'));
if ( function_exists($func) ) {
    $response = $func(in());
} else {
    $arr = explode('.', in('route'), 2);
    if (count($arr) != 2) error(e()->malformed_route);
    $className = $arr[0];
    $methodName = $arr[1];
    $filePath = ROOT_DIR . "routes/{$className}.route.php";
    if ( ! file_exists($filePath) ) error(e()->route_file_not_found);
    include $filePath;
    $instance = new ($className . 'Route')();

    if (!method_exists($instance, $methodName)) error(e()->route_function_not_found);

    setUserAsLogin( getProfileFromSessionId( in(SESSION_ID) ) );

    $response = $instance->$methodName(in());
}
success($response);
