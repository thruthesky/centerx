<?php declare(strict_types=1);
require_once ROOT_DIR . 'routes/app.route.php';
$app = new AppRoute();

isTrue($app->version());


