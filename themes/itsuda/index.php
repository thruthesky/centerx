<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.itsuda50.com/">
    <meta property="og:title" content="있수다">
    <meta property="og:description" content="있수다’ 에는?  건강 · 돈 · 친구가 있수다.">
    <meta property="og:image" content="https://www.itsuda50.com/themes/itsuda/img/logo.jpg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>있수다</title>
    <link rel="shortcut icon" type="image/x-icon" href="/themes/itsuda/favicon.ico"/>
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
        .w-200px { width: 200px; }
    </style>
    <script>
        const mixins = [];
        function later(fn) { window.addEventListener('load', fn); }
    </script>

</head>


<?php $isAdminPage = str_contains(theme()->page(), '/admin/'); ?>
<body <?php if (! $isAdminPage ) { echo 'style="padding-top: 80px;"'; } ?>>

<section id="app">
<?php if ( $isAdminPage ) { ?>
        <?php include theme()->page(); ?>
<?php } else { ?>
    <script>
        $(document).ready(function(){
            // Add smooth scrolling to all links
            $("a.scroll").on('click', function(event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;


                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top - 80
                    }, 300, function(){

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
        });
    </script>
    <section class="header position-fixed bg-white top w-100" style="z-index: 999">

        <div class="container">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="d-block w-200px">
                        <a href="/"><img class="py-3 pr-5 w-100" src="themes/itsuda/img/logo.jpg"></a>
                    </div>
                </div>
                <div class="mt-4">
<!--                    <a class="p-2" style="font-size: 1rem" href="/">다운로드</a>-->
                    <a class="p-2 scroll" style="font-size: 1rem; color:black;"  href="/#home3">서비스소개</a>
                    <a class="p-2 scroll" style="font-size: 1rem; color:black;"  href="/#home5">제휴서비스</a>
                    <a class="p-2" style="font-size: 1rem; color:black;" href="/?doc.privacy">개인정보처리방침</a>
                    <a href="https://play.google.com/store/apps/details?id=com.itsuda50.app3" target="_blank"><img src="themes/itsuda/img/android-download.png"></a>
                    <a href="https://apps.apple.com/pk/app/%EC%9E%88%EC%88%98%EB%8B%A4/id1560827977" target="_blank"><img src="themes/itsuda/img/ios-download.png"></a>
                    <?php if ( loggedIn() ) { ?>
                        <?php if ( admin() ) { ?>
                            <a class="p-2" style="font-size: 1.1rem" href="/?admin.index"><?=login()->name ?? 'Admin'?>(<?=login()->idx?>)</a>
                        <?php } ?>

                    <?php } ?>

                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <?php
        include theme()->page();
        ?>
    </div>
<?php } ?>
</section>

<script src="https://polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/helper.js?v=1', 10)?>
<?php js(HOME_URL . 'etc/js/vue-2.6.12-min.js', 3)?>
<?php js(HOME_URL . 'etc/js/app.js?v=3')?>
</body>
</html>