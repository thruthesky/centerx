<?php
require_once '/root/boot.php';

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





echo "\n=====================================> Begin Test at: " . date('r') . "\n\n";


foreach(glob('/root/tests/*.test.php') as $path) {
    if ( isset($argv[1]) ) {
        if ( strpos($path, $argv[1]) === false ) continue;
    }
    echo "===> Running $path\n";
    include $path;
    echo "\n";
}



echo "\nTests: $testCount\n";
if ( $errorCount ) echo "WARNING: ------------------------------------------> Errors: [ $errorCount ]\n";
else echo "No errors\n";
