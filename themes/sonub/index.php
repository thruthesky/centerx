<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <meta charset="utf-8">
<link rel="manifest" href="/themes/sonub/manifest.json">
<link rel="apple-touch-icon" href="/themes/sonub/img/philov-logo.png">
<meta name="theme-color" content="#1976d2">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/etc/bootstrap-4/bootstrap-4.6.0-min.css">
    <link rel="stylesheet" href="/etc/bootstrap-vue-2.21.2/bootstrap-vue-2.21.2.min.css">
    <link href="/etc/fontawesome-free-5/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/etc/css/x.css">
    <link rel="shortcut icon" type="image/x-icon" href="/themes/sonub/favicon.ico"/>
<!--    <link rel="manifest" href="manifest.json">-->
    <style>
        <?php include theme()->css('css/index') ?>
    </style>
    <script>
        <?php include theme()->file('js/prepare', extension: 'js'); ?>
    </script>
</head>
<body>
<section id="app">
    <?php if ( str_contains(theme()->page(), '/admin/') ) include theme()->page(); else { ?>
        <?php
        include theme()->file('header');
        ?>
        <div class="container-xl position-relative">
            <div class="left-wing">
                <?php include theme()->file('left'); ?>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 col-lg-9 px-1"><?php include theme()->page(); ?></div>
                <div class="d-none d-md-block col-4 col-lg-3"><?php include theme()->file('right'); ?></div>
            </div>
        </div>
        <?php
        include theme()->file('footer');
        ?>
    <?php } ?>
</section>


<?php if ( in('mode') == 'loggedIn' || in('mode') == 'registered' ) {?>
    <script>
        later(function() {
            saveToken(localStorage.getItem('pushToken'), location.hostname);
        })
    </script>
<?php } ?>

<script>
    // Check that service workers are supported
    if ('serviceWorker' in navigator) {
        // Use the window load event to keep the page load performant
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/themes/sonub/js/service-worker.js.php', {
                scope: '/'
            });
        });
    }
</script>



<!-- Load polyfills to support older browsers before loading Vue and Bootstrap Vue -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver%2CObject.fromEntries" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/common.js', 7)?>

<?php
    if ( isLocalhost() ) {
        js('/etc/js/vue.2.6.12.js', 5);
    }
    else {
        js('/etc/js/vue.2.6.12.min.js', 5);
    }
?>

<?php js('/etc/js/bootstrap-vue-2.21.2.min.js', 3)?>
<?php js( 'etc/js/toast.js', 0)?>
<?php js(theme()->url . 'js/data.js', 3)?>
<?php js(theme()->url . 'js/app.js', 0)?>
</body>
</html>
