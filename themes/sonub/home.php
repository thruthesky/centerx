<?php
if (cafe()->isSubCafe() && cafe()->notExists) {
?>
    <div class="p-2 fs-sm alert alert-warning">앗, 존재하지 않는 카페로 접속을 하였습니다. <a href="?cafe.create">카페 개설하기</a></div>
<?php
}

?>

<script>
    // console.log('firebase', firebase);
    //Cookies.set('a', 'Cherry', { domain: '//=COOKIE_DOMAIN?>//'});
    //alert(Cookies.get('a'));
    //Cookies.remove('a');
</script>

<?php


deleteAppCookie('a');
//
//d($_COOKIE);


?>


<?php

include widget('post/photo-and-texts-4-stories', [
    'title' => 'This is the title',
    'firstStories' => [
        'categoryId' => 'discussion',
        'limit' => 5,
    ],
    'secondStories' => [
        'categoryId' => 'qna',
    ],
]);

$firstStories = post()->latest(categoryId: 'qna', limit: 2);
$thirdStories = post()->latest(categoryId: 'qna', limit: 3);
include widget('post/photos-and-texts-3-stories', [
    'firstStories' => $firstStories,
    'secondStories' => [
        'title' => 'Most read articles',
        'categoryId' => 'discussion',
        'limit' => 5,
        'displayNumbers' => true
    ],
    'thirdStories' => $thirdStories,
]);

?>


<?php include widget('weather/openweathermap', ['display' => 'forecast']) ?>


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