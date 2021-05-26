<?php
if (cafe()->isSubCafe() && cafe()->notExists) {
?>
    <div class="p-2 fs-sm alert alert-warning">앗, 존재하지 않는 카페로 접속을 하였습니다. <a href="?cafe.create"><?=ln('create_cafe')?></a></div>
<?php
}



?>

<!-- work -->
<div class="mt-2 mt-lg-0"><?php include widget('post/two-column-story-group-a') ?></div>
<!-- /work -->
<hr>
<div class="d-xl-flex m-5">
    <div><img class="w-100" src="/themes/sonub/tmp/main2-1.jpg"></div>
    <div><img class="w-100" src="/themes/sonub/tmp/main2-2.jpg"></div>
</div>
<hr>
<br>
a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9 a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9
a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9 a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9
<template>
    <div class="mb-3">
        <b-button @click="toastNotification('Content')">Show Custom Toast</b-button>
        <b-button
                @click="toastNotification('Append Notification',{ title: 'append', position: 'bottom-full', append: true})">
            Show Toast (appended)</b-button>
    </div>
</template>

<script>
    console.log(mixins);
    mixins.push({
        methods: {
            toastNotification: function(content, options) {
                const o = Object.assign({
                    title: '',
                    buttons:
                        [
                            {
                                text: "Close",
                                class: "mr-3",
                                onclick: function() {
                                    console.log('Close');
                                }
                            },
                            {
                                text: "Open",
                                onclick: function() {
                                    console.log("Open");
                                    console.log(o.url);
                                    if( o.url ) location.href = o.url;
                                }
                            }
                        ]
                }, options);
                
                this.toast(content, o)
            },
        }
    });

    console.log(mixins);
</script>

<?php



include widget('post/photo-left-texts-right-top-4-photos-bottom', []);

$firstStories = post()->latest(categoryId: 'qna', countryCode: cafe()->countryCode, limit: 2, photo: true);
$thirdStories = post()->latest(categoryId: 'qna', countryCode: cafe()->countryCode, limit: 3, photo: true);
include widget('post/two-photo-top-texts-middle-3-photos-bottom', [
    'firstStories' => $firstStories,
    'secondStories' => [
        'title' => 'Most read articles',
        'categoryId' => 'qna',
        'limit' => 5,
        'displayNumbers' => true
    ],
    'thirdStories' => $thirdStories,
]);

?>


<?php include widget('weather/openweathermapforecast') ?>



<div class="p-2 fs-sm">
    <?php
    /// 환율 표시
    ///
    ///
    if (cafe()->isMainCafe() || cafe()->exists) {
        $currencies = cafe()->currency();
        if (isOk($currencies)) {

            $codes = array_key_first($currencies);
            list($src, $dst) = convert_currency_codes_to_names($codes);
            $rate = round_currency_rate($currencies[$codes]);
    ?>
            1<?= $src ?> <?= $rate ?><?= $dst ?>.

            <?php
            // 메인 사이트가 아니면,
            $country = get_current_country();
            if ($country->exists) {
                echo "접속: " . $country->CountryNameKR;
            }
            ?>

    <?php
        }
    }
    ?>







</div>

<div class="mb-2 mx-2 mx-lg-0">
    <img class="w-100 border-radius-md" src="themes/sonub/tmp/banner-wide2.jpg">
</div>

<div class="mb-2 mx-2 mx-lg-0 p-2 border-radius-md bg-light children-a-ellipsis">
    <?php
    include widget('post-latest/post-latest-default', ['categoryId' => 'discussion', 'limit' => 5, 'separator' => "<hr class='my-1 border-light'>"]);
    ?>
</div>

<div class="mb-2 mx-2 mx-lg-0 p-2 border-radius-md bg-light children-a-ellipsis">
    <?php
    post()->search(where: "files != ?", params: ['0']);
    ?>
</div>




<img class="w-100" src="themes/sonub/tmp/main.jpg">

<h1>Sonub Theme</h1>
<?php echo get_root_domain() ?>
<hr>
<?php if (loggedIn()) { ?>
    어서오세요, <?= login()->name ? login()->name : '이름 없음' ?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>

<hr>
themes/sonub/README.md 파일
<?php
$md = file_get_contents(theme()->folder . 'README.md');
include_once ROOT_DIR . 'etc/markdown/markdown.php';
echo Markdown::render($md);
?>