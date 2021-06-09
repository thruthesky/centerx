<?php

include '../../boot.php';
if (isset($_REQUEST['route'])) {
    include ROOT_DIR . 'controller/control.php';
    return;
}




$title = "HTML TITLE";

ob_start();
include widget('post/2x2-photo-top-text-bottom');
$latest_posts = ob_get_clean();


include view()->folder . 'index.html';
