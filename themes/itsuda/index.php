<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .top { top: 0; }
        .left { left: 0; }
        .fs-lg { font-size: 2rem; }
        .fs-title { font-size: 1.2rem; }
        .fs-desc { font-size: 0.85rem; color: #676565; }
        .hint { font-size: 0.8rem; color: #626963; }
        .em { color: darkred; font-weight: bold; }
        .border-radius-md { border-radius: 16px; }
        .opacity-0 { opacity: 0; }
    </style>
    <script>
        function later(fn) { window.addEventListener('load', fn); }
    </script>
</head>
<body>



<?php

include theme()->page();
?>


<script src="<?=HOME_URL?>etc/js/helper.js?v=2"></script>
</body>
</html>