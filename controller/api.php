<?php

if ( MATRIX_API_KEYS ) {
    if ( ! in('apiKey') ) error(e()->apikey_is_empty);
    if ( in_array(in('apiKey'), MATRIX_API_KEYS ) == false ) error(e()->apikey_is_wrong);
}

// login if session id is provided.
if ( in(SESSION_ID) ) {
    $profile = getProfileFromSessionId( in(SESSION_ID) );
    if ( isError($profile) ) error($profile);
    setUserAsLogin( $profile );
}


$route= in(ROUTE);
// User defined routes.
if ( $func = getRoute($route) ) {
    $response = $func(in());
} else {
    // Controller routes.
    $arr = explode('.', $route, 2);
    if (count($arr) != 2) error(e()->malformed_route);
    $className = $arr[0];
    $methodName = $arr[1];
    $filePath = CONTROLLER_DIR . "{$className}/{$className}.controller.php";
    if ( ! file_exists($filePath) ) error(err(e()->controller_file_not_found, $filePath));
    include $filePath;
    $className = str_replace('-', '', $className);
    $instance = new ($className . 'Controller')();

    if (!method_exists($instance, $methodName)) error(e()->controller_method_not_found);

    if ( in('test') ) enableTesting();
    $response = $instance->$methodName(in());
}

//
if ( is_array($response) ) {
    success($response);
} else if ( is_string($response) && str_starts_with($response, 'error_') ) {
    error($response);
} else if ( ! $response ) {
    error(e()->response_is_empty);
} else {
    error(e()->malformed_response);
}


