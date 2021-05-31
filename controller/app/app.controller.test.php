<?php
include "app.controller.php";
isTrue((new AppController())->version(), "App version");

$re = request("app.version");
isTrue($re['version'], "App version");
isTrue((new AppController())->version(), "must be same");
