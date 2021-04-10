<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
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
<script>
    mixins.push({
        data: function() {
            return {
                name: 'sonub'
            }
        }
    })
    later(function(){
       console.log(app.name);
    });
</script>
<section id="app">
    <?php if ( str_contains(theme()->page(), '/admin/') ) include theme()->page(); else { ?>
        <?php
        include theme()->file('header');
        ?>
        <div class="container-xl">
            <div class="row">
                <div class="d-none d-md-block col-3"><?php include theme()->file('left'); ?></div>
                <div class="col p-0 m-0"><?php include theme()->page(); ?></div>
                <div class="d-none d-lg-block col-3"><?php include theme()->file('right'); ?></div>
            </div>
        </div>
        <?php
        include theme()->file('footer');
        ?>
    <?php } ?>
</section>
<?php js(HOME_URL . 'etc/js/helper.js')?>
<?php js(HOME_URL . 'etc/js/vue.2.min.js')?>
<?php js(HOME_URL . 'etc/js/app.js')?>
</body>
</html>
