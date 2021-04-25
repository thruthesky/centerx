<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/etc/bootstrap-4/bootstrap-4.6.0-min.css">
    <link rel="stylesheet" href="/themes/sonub/css/bootstrap-vue-2.21.2.min.css">
    <link href="/etc/fontawesome-pro-5/css/all.css" rel="stylesheet">
    <style>
        <?php include theme()->css('index') ?>
    </style>
    <script>
        const mixins = []; // Vue.js 2 의 mixin 들을 담을 변수
        function later(fn) { window.addEventListener('load', fn); }
    </script>
</head>
<body>
<section id="app">
    <?php if ( str_contains(theme()->page(), '/admin/') ) include theme()->page(); else { ?>
        <?php
        include theme()->file('header');
        ?>
        <div class="container-xl">
            <div class="row">
                <div class="d-none d-md-block col-4 col-lg-3"><?php include theme()->file('left'); ?></div>
                <div class="col-12 col-md-8 col-lg-6 p-0 m-0"><?php include theme()->page(); ?></div>
                <div class="d-none d-lg-block col-3"><?php include theme()->file('right'); ?></div>
            </div>
        </div>
        <?php
        include theme()->file('footer');
        ?>
    <?php } ?>
</section>
<!-- Load polyfills to support older browsers before loading Vue and Bootstrap Vue -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/helper.js', 7)?>
<?php js(HOME_URL . 'etc/js/vue-2.6.12-min.js', 2)?>
<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 1)?>
<?php js(HOME_URL . 'etc/js/app.js', 0)?>
</body>
</html>
