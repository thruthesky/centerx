<?php


include './boot.php'; // load booting scripts
if ( in(ROUTE) ) return include ROOT_DIR . 'routes/index.php';

// 스크립트 파일이 .submit.php 으로 끝나면, 테마를 로드하지 않고, PHP 만 실행한다. 이 때, style 이나 javascript 를 캡쳐해서 밑으로 내리지 않는다.
if (str_ends_with(in('p', ''), '.submit') ) {
    include theme()->file(in('p'));
}
else {
    ob_start();
    include theme()->file('index');
    $html = ob_get_clean();
    $captured_scripts_and_styles = capture_styles_and_scripts($html);
    $js_tags = get_javascript_tags($captured_scripts_and_styles);
    $html = str_ireplace("</body>", $js_tags . "\n</body>", $html);
    echo $html;
}

