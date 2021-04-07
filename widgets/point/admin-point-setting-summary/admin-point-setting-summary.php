<?php
$registered = user()->count();
$now = time();
$ago = $now - 60 * 30;
$login = user()->count(where: "updatedAt<='$now' AND updatedAt>='$ago'");


?>
<style>
    .fw-700 {
        font-weight: 700;
    }
    .bg-skyblue {
        background: #CAF9FF;
    }
    .color-lightblue {
        color: #00B4CB;
    }
    .hw-54x54 {
        height: 54px;
        width: 54px;
    }
</style>

<section class="d-flex justify-content-between py-3 px-4" id="admin-point-setting-summary">
    <div>
        <div class="d-flex justify-content-center align-items-center hw-54x54 rounded-circle bg-skyblue color-lightblue fw-700">Point</div>
    </div>
    <div class="d-flex">
        <div class="text-right fw-700">
            <div><?=$registered?></div>
            <div><?=$login?></div>
            <div><?=config(POINT_LIKE, 0)?>/<?=config(POINT_LIKE_DEDUCTION, 0)?></div>
            <div><?=config(POINT_DISLIKE, 0)?>/<?=config(POINT_DISLIKE_DEDUCTION, 0)?></div>
            <div><?=config(POINT_LIKE_HOUR_LIMIT, 0)?></div>
            <div><?=config(POINT_LIKE_HOUR_LIMIT_COUNT, 0)?></div>
            <div><?=config(POINT_LIKE_DAILY_LIMIT_COUNT, 0)?></div>

        </div>
        <div class="px-3">
            <div>- <?=ek('Registered', '등기')?></div>
            <div>- <?=ek('Login', '로그인')?></div>
            <div>- <?=ek('Like', '처럼')?></div>
            <div>- <?=ek('Dislike', '싫어함')?></div>
            <div>- <?=ek('Hour Limit', '시간 제한')?></div>
            <div>- <?=ek('Change/Hour', '변경 / 시간')?></div>
            <div>- <?=ek('Daily Limit', '일일 한도')?></div>
        </div>
    </div>
</section>