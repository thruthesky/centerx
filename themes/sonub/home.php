<?php
if ( cafe()->isSubCafe() && cafe()->notExists ) {
    ?>
    <div class="p-2 fs-sm alert alert-warning">앗, 존재하지 않는 카페로 접속을 하였습니다. <a href="?cafe.create">카페 개설하기</a></div>
    <?php
}
?>


<div class="p-2 fs-sm">
    <?php
    /// 환율 표시
    ///
    ///
    if ( cafe()->isMainCafe() || cafe()->exists ) {
        $currencies = cafe()->currency();
        $codes = array_key_first($currencies);
        list($src, $dst) = convert_currency_codes_to_names($codes);
        $rate = round_currency_rate($currencies[$codes]);
        ?>
        1<?=$src?> <?=$rate?><?=$dst?>.
        <?php
    }
    ?>
    마닐라 맑음(23.4도), 세부 맑음(24.1도).

</div>

<img class="w-100" src="themes/sonub/tmp/banner-wide2.jpg">

<img class="w-100" src="themes/sonub/tmp/main.jpg">

<h1>Sonub Theme</h1>
<?php echo get_root_domain() ?>
<hr>
<?php if ( loggedIn() ) { ?>
    어서오세요, <?=login()->name ? login()->name : '이름 없음'?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>

<hr>
themes/sonub/README.md 파일
<?php
$md = file_get_contents(theme()->folder . 'README.md');
include_once ROOT_DIR . 'etc/markdown/markdown.php';
echo Markdown::render ($md);
?>

