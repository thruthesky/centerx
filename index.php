<?php
ob_start();
include './boot.php';
include theme()->file('index');
$html = ob_get_clean();
echo $html;
