<?php

setLoginAsAdmin();


$re = _banner_create();
isTrue ( isError($re) == false, "banner create must success");

