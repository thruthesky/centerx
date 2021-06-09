<?php

include '../../boot.php';
if (isset($_REQUEST['route'])) {
    include ROOT_DIR . 'controller/control.php';
    return;
}





function display_title() {
    echo "HTML TITLE";
}
function display_latest_posts() {
    echo "Yo<hr>";
}

include view()->folder . 'index.html';
