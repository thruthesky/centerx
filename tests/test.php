<?php

$rootDir = str_replace("/tests", "", __DIR__);
require_once  $rootDir . '/boot.php';

enableTesting();

$testCount = 0;
$errorCount = 0;



/**
 * @param $t
 * @param string $msg
 *
 * @example
 *  isTrue(isError(...));
 *  isTrue(isSuccess(...));
 */
function isTrue($t, string $msg = '') {
    global $testCount, $errorCount;
    if ( $t ) {
        echo '.';
    }
    else {
        $stacks = debug_backtrace();
        echo "x($msg)";
        echo "\n----------------------------------------------------------------------\n";
        print_r($stacks);
        echo "\n----------------------------------------------------------------------\n";
//        echo "\n\n-----------------------------------------\n$msg >>> $info[file] at line: $info[line]\n-----------------------------------------\n\n";
        $errorCount ++;
    }
    $testCount ++;
}


/**
 * Create a test user or login the test user that has just created for the test session.
 * @return UserModel
 */
function createTestUser(): UserModel {
    $email = 'user-register' . time() . '@test.com';
    $pw = '12345a';
    return user()->loginOrRegister([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'blue']);
}


// Does not support flag GLOB_BRACE
function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}


echo "\n\n=====================================> Begin Test at: " . date('r') . "\n\n";

$test_path_1 = $rootDir . '/controller/**/*.test.php';
$test_path_2 = $rootDir . '/tests/*.test.php';
echo "Searching path: $test_path_1, $test_path_2\n\n";

$test_files = array_merge(glob($test_path_1), glob($test_path_2));

foreach($test_files as $path) {
    if ( isset($argv[1]) ) {
        if ( strpos($path, $argv[1]) === false ) continue;
    }
    echo "===> Running $path\n";
    include $path;
    echo "\n";
}




echo "\nTests: $testCount\n";
if ( $errorCount ) echo "WARNING: ------------------------------------------> Errors: [ $errorCount ]\n";
else echo "Congratulations! No errors.\n";
