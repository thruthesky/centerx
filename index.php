<?php
include './boot.php';
if ( in(ROUTE) ) return include ROOT_DIR . 'routes/index.php';
ob_start();
include theme()->file('index');
$html = ob_get_clean();
echo $html;
