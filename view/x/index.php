<?php
include '../../boot.php';
if ( isset($_REQUEST['route']) ) {
    include ROOT_DIR .'controller/control.php';
    return;
}
include ROOT_DIR . 'var/cafe.index.php';
include view()->folder . 'index.html';
