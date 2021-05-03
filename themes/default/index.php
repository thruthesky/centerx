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
        .fs-title { font-size: 1.2rem; }
        .fs-desc { font-size: 0.85rem; color: #676565; }
    </style>
    <script>
        const mixins = [];
        function later(fn) { window.addEventListener('load', fn); }
    </script>
</head>
<body>

<section id="app">
    <?php
    include theme()->page();
    ?>
</section>
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/helper.js')?>
<?php js(HOME_URL . 'etc/js/vue-2.6.12-min.js')?>
<?php js(HOME_URL . 'etc/js/vue-js-components/upload-by-code.js')?>
<?php js(HOME_URL . 'etc/js/app.js')?>
</body>
</html>