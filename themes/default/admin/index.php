<?php
if ( admin() == false ) jsBack('You are not admin');
?>
<link rel="stylesheet" href="themes/default/admin/admin.css">

<section class="layout">
    <div class="container-fluid bg-dark">
        <nav class="container navbar white fs-xs py-0">
            <div class="white py-3">
                <a class="mr-1 py-3" href="/?p=admin.index"><?=ek('Dashboard', 'Dashboard')?></a> |
                <a class="ml-1 py-3" href="/"><?=ek('Home', 'Home')?></a>
            </div>
                <div class="ml-auto white">
                        <a class="mr-1 py-3" href="/?p=admin.index&w=setting/admin-setting"><?=ln(['en' => 'Settings', 'ko' => '설정'])?></a>|
                        <a class="mx-1 py-3" href="/?p=admin.index&w=setting/upload-image&code=admin.app.about.setting"><?=ln(['en' => 'About', 'ko' => '어바웃 설정'])?></a>|
                        <a class="mx-1 py-3" href="/?p=admin.index&w=point/admin-point-setting"><?=ln(['en' => 'Point Setting', 'ko' => '포인트 설정'])?></a>|
                        <a class="mx-1 py-3" href="/?p=admin.index&w=setting/admin-translation"><?=ln(['en' => 'Translations', 'ko' => '언어화'])?></a>|
                        <a class="ml-1 py-3" href="/?p=admin.index&w=point/admin-point-history"><?=ln(['en' => 'Point history', 'ko' => '포인트 기록'])?></a>
                </div>
        </nav>
    </div>

    <div class="container-fluid bg-light">
        <div class="container d-flex justify-content-between py-3">
            <div class="mr-5">
                <div class="fs-xl">CenterX</div>
            </div>
            <div class="d-flex justify-content-start mr-auto">
                <a href="/?p=admin.index&w=user/admin-user-list">
                    <div class="fs-lg"><?=ek('Users', '사용자')?></div>
                    <div class="fs-sm text-muted">recent activities</div>
                </a>
                <div class="divider mx-4"></div>
                <a href="/?p=admin.index&w=post-list/admin-post-list">
                    <div class="fs-lg">Forum</div>
                    <div class="fs-sm text-muted">recent posts & comments</div>
                </a>
                <div class="divider mx-4"></div>
                <a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall">
                    <div class="fs-lg"><?=ln(['en' => 'Shopping Mall', 'ko' => '쇼핑몰'])?></div>
                    <div class="fs-sm text-muted">Create Items, View Orders, ...</div>
                </a>
                <div class="divider mx-4"></div>
                <a href="/?p=admin.index&w=in-app-purchase/admin-purchase-list">
                    <div class="fs-lg"><?=ln(['en' => 'In App Purchase', 'ko' => '인앱 구매'])?></div>
                    <div class="fs-sm text-muted">Purchases & stats</div>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content py-4">
            <?php
            if ( in('w') ) include widget(in('w'));
            else include theme()->file('admin/dashboard');
            ?>
        </div>
    </div>
</section>
