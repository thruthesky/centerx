<?php

$title = "HTML TITLE";

ob_start();
include widget('post/2x2-photo-top-text-bottom');
$latest_posts = ob_get_clean();

include view()->folder . 'dist/index.html';

//$html = file_get_contents(view()->folder . 'dist/index.html');
//
//$html = str_replace("<!--php:title-->", "New title", $html);
//echo $html;


