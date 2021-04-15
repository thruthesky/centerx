<?php
if (admin() == false) jsBack('You are not admin');
?>
<link rel="stylesheet" href="themes/default/admin/admin.css?v=3">

<section class="layout" style="background-color: #cceef2;">
    <div class="container-fluid" style="background-color: #181c32;">
        <nav class="container navbar white fs-sm fw-700 py-0" style="height: 65px;">
            <div class="white py-3">
                <a class="mr-2 py-3" href="/?p=admin.index"><?= ek('Dashboard', 'Dashboard') ?></a>
                <a class="ml-2 py-3" href="/"><?= ek('Home', 'Home') ?></a>
            </div>
            <div class="ml-auto white">
                <a class="mr-2 py-3" href="/?p=admin.index&w=setting/admin-setting"><?= ln(['en' => 'Settings', 'ko' => '설정']) ?></a>
                <a class="mx-2 py-3" href="/?p=admin.index&w=setting/upload-image&code=admin.app.about.setting"><?= ln(['en' => 'About', 'ko' => '어바웃 설정']) ?></a>
                <a class="mx-2 py-3" href="/?p=admin.index&w=point/admin-point-setting"><?= ln(['en' => 'Point Setting', 'ko' => '포인트 설정']) ?></a>
                <a class="mx-2 py-3" href="/?p=admin.index&w=setting/admin-translation"><?= ln(['en' => 'Translations', 'ko' => '언어화']) ?></a>
                <a class="mx-2 py-3" href="/?p=admin.index&w=point/admin-point-history"><?= ln(['en' => 'Point history', 'ko' => '포인트 기록']) ?></a>
                <a class="ml-2 py-3" href="/?p=admin.index&w=push-notification/push-notification-create"><?= ln(['en' => 'Notification', 'ko' => 'Notification']) ?></a>
            </div>
        </nav>
    </div>

    <div class="container-fluid bg-light">
        <div class="container d-flex justify-content-between align-items-center sub-menu" style="height: 80px;">
            <div class="mr-5">
                <a href="/?admin.index" class="fs-xl">CenterX</a>
            </div>
            <span class="flex-grow-1"></span>
            <div class="d-flex h-100">
                <a class="sub-menu-item <?= in('w') == 'user/admin-user-list' ? 'active' : '' ?>" href="/?p=admin.index&w=user/admin-user-list">
                    <div class="sub-menu-item-label">
                        <div class="sub-menu-title fw-500"><?= ek('Users', '사용자') ?></div>
                        <div class="sub-menu-desc fw-400">recent activities</div>
                    </div>
                </a>
                <a class="sub-menu-item <?= in('w') == 'category/admin-category-list' ? 'active' : '' ?>" href="/?p=admin.index&w=category/admin-category-list">
                    <div class="sub-menu-item-label border-left-grey">
                        <div class="sub-menu-title fw-500">Forum</div>
                        <div class="sub-menu-desc fw-400">recent posts & comments</div>
                    </div>
                </a>
                <a class="sub-menu-item <?= in('w') == 'shopping-mall/admin-shopping-mall' ? 'active' : '' ?>" href="/?p=admin.index&w=shopping-mall/admin-shopping-mall">
                    <div class="sub-menu-item-label border-left-grey">
                        <div class="sub-menu-title fw-500"><?= ln(['en' => 'Shopping Mall', 'ko' => '쇼핑몰']) ?></div>
                        <div class="sub-menu-desc fw-400">Create Items, View Orders, ...</div>
                    </div>
                </a>
                <a class="sub-menu-item <?= in('w') == 'in-app-purchase/admin-purchase-list' ? 'active' : '' ?>" href="/?p=admin.index&w=in-app-purchase/admin-purchase-list">
                    <div class="sub-menu-item-label border-left-grey">
                        <div class="sub-menu-title fw-500"><?= ln(['en' => 'In App Purchase', 'ko' => '인앱 구매']) ?></div>
                        <div class="sub-menu-desc fw-400">Purchases & stats</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content py-4">
            <?php

            if (in('w')) { ?>
                <div class="p-3 bg-white"><?php include widget(in('w')); ?></div>
            <?php
            } else include theme()->file('admin/dashboard');
            ?>
        </div>
    </div>
</section>