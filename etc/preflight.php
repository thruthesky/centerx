<?php
/**
 * @file preflight.php
 */
/**
 * @attention Preflight 을 route/index.php 에 넣으니 플러터 웹에서 Cors 문제가 발생한다.
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true'); // Required for cookies, authorization headers with HTTPS
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    echo ''; // No return data for preflight.
    exit;
}


