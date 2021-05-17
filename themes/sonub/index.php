<!doctype html>
<html lang="en">
<head>
    <title>소너브!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/etc/bootstrap-4/bootstrap-4.6.0-min.css">
    <link rel="stylesheet" href="/etc/bootstrap-vue-2.21.2/bootstrap-vue-2.21.2.min.css">
    <link href="/etc/fontawesome-pro-5/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="/themes/sonub/favicon.ico"/>
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
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver%2CObject.fromEntries" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/helper.js', 7)?>

<?php
    if ( isLocalhost() ) {
        js(HOME_URL . 'etc/js/vue.2.6.12.js', 5);
    }
    else {
        js(HOME_URL . 'etc/js/vue.2.6.12.js', 5);
    }
?>

<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 3)?>
<?php js(theme()->url . 'js/data.js', 3)?>
<?php js(theme()->url . 'js/app.js', 0)?>

<script>
    addEventListener('pushNotification', function(){
        console.log("addEventListener('pushNotification'");
    });
    const config = {
        themeFolderName: "<?=theme()->url?>",
        firebaseConfig: {
            apiKey: "AIzaSyDWiVaWIIrAsEP-eHq6bFBY09HLyHHQW2U",
            authDomain: "sonub-version-2020.firebaseapp.com",
            databaseURL: "https://sonub-version-2020.firebaseio.com",
            projectId: "sonub-version-2020",
            storageBucket: "sonub-version-2020.appspot.com",
            messagingSenderId: "446424199137",
            appId: "1:446424199137:web:f421c562ba0a35ac89aca0",
            measurementId: "G-F86L9641ZQ"
        },
        defaultTopic: "<?=DEFAULT_TOPIC?>",
        post_notification_prefix: '<?=NOTIFY_POST?>',
        comment_notification_prefix: '<?=NOTIFY_COMMENT?>',
    };
</script>
<?php js('https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js')?>
<?php js('https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js')?>
<?php js(theme()->url . 'js/firebase.js')?>
</body>
</html>
