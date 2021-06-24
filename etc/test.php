<?php



include '../boot.php';

d("isLocalhost(): ");
if ( isLocalhost() ) d("yes, it is localhost");
else d('no, it is not localhost');
