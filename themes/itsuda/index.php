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
        .w-200px { width: 200px; }
    </style>
    <script>
        function later(fn) { window.addEventListener('load', fn); }
    </script>
</head>
<body style="padding-top: 80px;">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
<?php

?>
<?php if ( str_contains(theme()->page(), '/admin/') ) { ?>
    <?php include theme()->page(); ?>
<?php } else { ?>
        <section class="header position-fixed bg-white top w-100">

            <div class="container">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-block w-200px">
                            <a href="/"><img class="py-3 pl-5 w-100" src="themes/itsuda/img/logo.jpg"></a>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a class="p-2" style="font-size: 1rem" href="/">다운로드</a>
                        <a class="p-2 scroll" style="font-size: 1rem" href="/#home3">서비스소개</a>
                        <a class="p-2 scroll" style="font-size: 1rem" href="/#home5">제휴서비스</a>
                        <a class="p-2" style="font-size: 1rem" href="/?doc.privacy">개인정보처리방침</a>
                        <?php if ( loggedIn() ) { ?>
                            <?php if ( admin() ) { ?>
                                <a class="p-2" style="font-size: 1.1rem" href="/?admin.index"><?=login()->name?>(<?=login()->idx?>)</a>
                            <?php } ?>

                            <a class="p-2" style="font-size: 1.1rem" href="/?p=forum.post.list&categoryId=qna"><?=ln(['en' => 'QnA', 'ko' => '질문게시판'])?></a>
                            <a class="p-2" style="font-size: 1.1rem" href="/?p=forum.post.list&categoryId=discussion"><?=ln(['en' => 'Discussion', 'ko' => '자유게시판'])?></a>
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

<script src="<?=HOME_URL?>etc/js/helper.js?v=2"></script>
</body>
</html>