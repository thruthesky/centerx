<?php

$re = request('app.version');

isTrue($re['version'], "Version success");
