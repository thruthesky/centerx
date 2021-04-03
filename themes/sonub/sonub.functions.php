<?php
require_once ROOT_DIR . 'lib/cafe.class.php';


$_domain = get_domain();
if ( array_key_exists($_domain, CAFE_ROOT_DOMAIN) == false ) $_domain = '';
cafe($_domain);


