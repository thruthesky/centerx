<?php


live_reload_js();

//error handler function
function customError($errno, $errstr, $error_file, $error_line) {
    echo <<<EOE
<div style="padding: 16px; border-radius: 10px; background-color: #5a3764; color: white;">
    <div>PHP ERROR</div>
    <div style="margin-top: 16px; padding: 16px; border-radius: 10px; background-color: white; color: black;">
        <b>Error:</b> [$errno] $errstr in $error_file at line $error_line
    </div>
</div>
EOE;
}

//set error handler
set_error_handler("customError");


