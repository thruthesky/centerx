<?php

include '../../boot.php';
//$cafe = cafe(domain: get_host_name());
//d($cafe); exit;


if ( isset($_SERVER['PHP_SELF']) && str_contains($_SERVER['PHP_SELF'], 'manifest.json') ) {
    $str = file_get_contents(view()->folder . 'manifest.json');
    $json = json_decode($str, true);
    $cafe = cafe(domain: get_host_name());

    $json['lang'] = 'en';
    $json['start_url'] = "/?start_url=pwa";
    $json['orientation'] = "natural";
    $json['scope'] = "/";
    $json['theme_color'] = "#ffffff";

    if (!in_array(get_host_name(), $cafe->mainCafeDomains)) {
        $json['background_color'] = $cafe->app_background_color;
        $json['name'] = $cafe->title;
        $json['short_name'] = $cafe->app_name;
        $json['description'] = $cafe->description;

        //get uploaded app icon
        $appIcon = $cafe->appIcon();
        if($appIcon->ok) {
            $json['icons'] = [
                [
                    'src' => $appIcon->url,
                    "sizes" => "512x512",
                    "type" => "image/png",
                    "purpose" => "any maskable",
                ],
            ];
        }

    }

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
