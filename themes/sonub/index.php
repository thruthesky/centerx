<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="/etc/fontawesome-pro-5/css/all.css" rel="stylesheet">
    <style>
        <?php include theme()->css('index') ?>
    </style>
</head>
<body>
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
</body>
</html>










