<?php
/**
 * @file test.php
 */

$rootDir = str_replace("/tests", "", __DIR__);

/// For testing, boot will happens once. Without calling controllers/control.php
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

function request(string $route, array $data = []) {


    $endpoint = 'http://www_docker_nginx/index.php';


    $data['route'] = $route;

    /// By giving &test=1, it enables the test mode on backend.
    $data['test'] = 1;
    $postdata = http_build_query( $data );

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context = stream_context_create($opts);

    $result = file_get_contents($endpoint, false, $context);

    $json = json_decode($result, true);

    if ( $json === null ) {
        echo "\n>\n>\n> json_decode() failed. There might an error on backend. Backend data:\n>\n>\n";
        echo $result;
        echo "\n\n\n";
        return null;
    }


    return $json['response'];

}



echo "\n\n=====================================> Begin Test at: " . date('r') . "\n\n";

$test_path_0 = $rootDir . '/model/**/*.test.php';
$test_path_1 = $rootDir . '/controller/**/*.test.php';
$test_path_2 = $rootDir . '/controller/*.test.php';
$test_path_3 = $rootDir . '/tests/*.test.php';
echo "\n>\n>\n> Searching path: $test_path_0, $test_path_1, $test_path_2, $test_path_3\n>\n>\n";

$test_files = array_merge(glob($test_path_0), glob($test_path_1), glob($test_path_2), glob($test_path_3));

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
