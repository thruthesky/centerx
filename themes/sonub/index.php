<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="/etc/fontawesome-free-5/css/all.css" rel="stylesheet">
    <style>
        <?php include theme()->css('index') ?>
    </style>
    <style>
        .l-content {
            margin: 0 auto;
            max-width: <?=L_CONTENT?>px;
            overflow: hidden;
        }
        .l-left {
            min-width: <?=L_LEFT?>px;
        }
    </style>
</head>
<body>
<?php
    include theme()->file('header');
    ?>
<table class="l-content" width="<?=L_CONTENT?>" cellpadding="0" cellspacing="0">
    <tr valign="top">
        <td width="<?=L_LEFT?>"><section class="l-left bg-blue mh-1024px"><?php include theme()->file('left'); ?></section></td>
        <td width="<?=L_CENTER?>"><section class="l-center <?=inHome() ? 'mx-3' : 'ml-3'?>"><?php include theme()->page(); ?></section></td>
        <?php if ( inHome() ) { ?>
            <td width="<?=L_RIGHT?>"><section class="l-right mh-1024px"><?php include theme()->file('right'); ?></section></td>
        <?php } ?>
    </tr>
</table>
<?php
    include theme()->file('footer');
?>
</body>
</html>
