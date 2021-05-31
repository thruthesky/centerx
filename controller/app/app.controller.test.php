<?php
include "app.controller.php";
isTrue((new AppController())->version(), "App version");


$re = request("app.version");

