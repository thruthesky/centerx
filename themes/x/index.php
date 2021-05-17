<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/etc/bootstrap-4/bootstrap-4.6.0-min.css">
    <link rel="stylesheet" href="/etc/bootstrap-vue-2.21.2/bootstrap-vue-2.21.2.min.css">
    <link href="/etc/fontawesome-pro-5/css/all.min.css" rel="stylesheet">
    <style>
        <?php include theme()->css('css/index') ?>
    </style>
    <script>
        <?php include theme()->file('js/prepare', extension: 'js'); ?>
    </script>
</head>
<body>
<section id="app">
    <?php include theme()->page();?>
</section>
<!-- Load polyfills to support older browsers before loading Vue and Bootstrap Vue -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver%2CObject.fromEntries" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/helper.js', 7)?>
<?php js(HOME_URL . 'etc/js/vue.2.6.12.min.js', 2)?>
<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 1)?>
<?php js(theme()->url . 'js/data.js', 1)?>
<?php js(theme()->url . 'js/app.js', 0)?>
</body>
</html>
