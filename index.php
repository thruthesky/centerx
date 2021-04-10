<?php


include './boot.php'; // load booting scripts
if ( in(ROUTE) ) return include ROOT_DIR . 'routes/index.php';
ob_start();
if (str_ends_with(in('p', ''), '.submit') ) include theme()->file(in('p'));
else include theme()->file('index');
$html = ob_get_clean();


$captured = capture_styles_and_scripts($html);
$js_tags = get_javascript_tags();
$html = str_ireplace("</body>", $captured . $js_tags . "\n</body>", $html);

echo $html;

