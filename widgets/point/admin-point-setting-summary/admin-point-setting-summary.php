<?php
$registered = user()->count();
$now = time();
$ago = $now - 60 * 30;
$login = user()->count(where: "updatedAt<=? AND updatedAt>=?", params: [$now, $ago]);
?>

<section class="d-flex justify-content-between py-3 px-4" data-cy="admin-point-setting-summary-widget">
    <div>
        <div class="d-flex justify-content-center align-items-center hw-54x54 rounded-circle bg-skyblue color-lightblue fw-700"><?= ln(['en' => 'Point', 'ko' => '포인트']) ?></div>
        <a href="/?p=admin.index&w=point/admin-point-setting" class="btn btn-sm btn-info mt-2"><?= ln('setting') ?></a>
    </div>
    <div class="d-flex">
        <div class="text-right fw-700">
            <div><?= $registered ?></div>
            <div><?= $login ?></div>
            <div><?= metaConfig(Actions::$like, 0) ?>/<?= metaConfig(Actions::$likeDeduction, 0) ?></div>
            <div><?= metaConfig(Actions::$dislike, 0) ?>/<?= metaConfig(Actions::$dislikeDeduction, 0) ?></div>
            <!--            <div>-->
            <?//=metaConfig(POINT_LIKE_HOUR_LIMIT, 0)?>
            <!--</div>-->
            <!--            <div>-->
            <?//=metaConfig(POINT_LIKE_HOUR_LIMIT_COUNT, 0)?>
            <!--</div>-->
            <!--            <div>-->
            <?//=metaConfig(POINT_LIKE_DAILY_LIMIT_COUNT, 0)?>
            <!--</div>-->
        </div>
        <div class="px-3">
            <div>- <?= ln(['en' => 'Registered', 'ko' => '등기']) ?></div>
            <div>- <?= ln('login') ?></div>
            <div>- <?= ln('like') ?></div>
            <div>- <?= ln('dislike') ?></div>
            <!--            <div>- -->
            <?//=ek('Hour Limit', '시간 제한')?>
            <!--</div>-->
            <!--            <div>- -->
            <?//=ek('Change/Hour', '변경 / 시간')?>
            <!--</div>-->
            <!--            <div>- -->
            <?//=ek('Daily Limit', '일일 한도')?>
            <!--</div>-->
        </div>
    </div>
</section>