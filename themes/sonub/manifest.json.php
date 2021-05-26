<?php
header("Content-Type: application/json");
include '../../boot.php';

if( cafe()->title ) $name = cafe()->title;
else $name = cafe()->name();

if( cafe()->app_name ) $appName = cafe()->app_name;
else $appName = cafe()->name();

if( cafe()->app_background_color ) $appColor = cafe()->app_background_color;
else $appColor = 'white';


$src = "/themes/sonub/tmp/pwa-512.png";
$icon = cafe()->appIcon();
if ( $icon->exists ) {
    $src = $icon->url;
}



?>{
  "lang": "en",
  "background_color": "<?=$appColor?>",
  "description": "<?=cafe()->description?>",
  "display": "fullscreen",
  "icons": [
    {
      "src": "<?=$src?>",
      "sizes": "512x512",
      "type": "image/png",
      "purpose": "any maskable"
    }
  ],
  "name": "<?=$name?>",
  "short_name": "<?=$appName?>",
  "start_url": "/themes/sonub/pwa.php",
  "orientation": "natural",
  "theme_color": "aliceblue",
  "scope": "/"
}