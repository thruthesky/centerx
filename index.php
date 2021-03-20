<?php

include './boot.php';
if ( in(ROUTE) ) return include ROOT_DIR . 'routes/index.php';
ob_start();
if (str_ends_with(in('p', ''), '.submit') ) include theme()->file(in('p'));
else include theme()->file('index');
$html = ob_get_clean();
echo $html;

