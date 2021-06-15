<?php

include '../../boot.php';

if ( isset($_SERVER['PHP_SELF']) && str_contains($_SERVER['PHP_SELF'], 'manifest.json') ) {
    $str = file_get_contents(view()->folder . 'manifest.json');
    $json = json_decode($str, true);

    $json['lang'] = 'en';
    $json['background_color'] = 'red';
    $json['theme_color'] = "#4DBA87";
    $json['name'] = "The CHANGED name";
    $json['short_name'] = "The NEW short name";
    $json['description'] = "";
    $json['icons'] = [
        [
            'src' => "https://wwnymous.png",
            "sizes" => "512x512",
            "type" => "image/png",
            "purpose" => "any maskable",
        ],
    ];
    $json['start_url'] = "/?start_url=pwa";
    $json['orientation'] = "natural";
    $json['scope'] = "/";

    header("Content-Type: application/json");
    echo json_encode($json);
    exit;
}

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
