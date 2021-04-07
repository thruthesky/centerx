<?php
if ( admin() == false ) jsBack('You are not admin');
?>
<style>
    .layout .content {
        padding: 1rem;
        border-radius: 1rem;
        background-color: #eeede7;
    }
    .menu a[href*="<?=in('w')?>"] {
        color: yellow !important;
    }
    .fs-xs {
        font-size: 12px;
    }
    .fs-sm {
        font-size: 14px;
    }
    .fs-md {
        font-size: 16px;
    }
    .fs-lg {
        font-size: 28px;
    }
    .fs-xl {
        font-size: 36px;
    }
    .fs-xxl {
        font-size: 52px;
    }
    .navbar {
        height: 52px;
    }
    .white {
        color: white;
    }
    .white a {
        color: white;
    }
    .fw-400 {
        font-weight: 400;
    }
</style>

<section class="layout">
    <div class="container-fluid bg-dark">
        <nav class="container navbar white fs-xs">
            <div class="white">
                <a class="mr-1" href="/?p=admin.index"><?=ek('Dashboard', 'Dashboard')?></a> |
                <a class="ml-1" href="/"><?=ek('Home', 'Home')?></a>
            </div>
                <div class="ml-auto white">
                        <a class="mr-1" href="/?p=admin.index&w=setting/admin-setting"><?=ln(['en' => 'Settings', 'ko' => '설정'])?></a>|
                        <a class="mx-1" href="/?p=admin.index&w=setting/upload-image&code=admin.app.about.setting"><?=ln(['en' => 'About', 'ko' => '어바웃 설정'])?></a>|
                        <a class="mx-1" href="/?p=admin.index&w=point/admin-point-setting"><?=ln(['en' => 'Point Setting', 'ko' => '포인트 설정'])?></a>|
                        <a class="mx-1" href="/?p=admin.index&w=setting/admin-translation"><?=ln(['en' => 'Translations', 'ko' => '언어화'])?></a>|
                        <a class="ml-1" href="/?p=admin.index&w=point/admin-point-history"><?=ln(['en' => 'Point history', 'ko' => '포인트 기록'])?></a>
                </div>
        </nav>
    </div>

    <div class="container-fluid bg-light">
        <div class="container d-flex justify-content-between py-1">
            <div>
                <div class="fs-xl">CenterX</div>
            </div>
            <div>
                <div class="fs-lg">Users</div>
                <div class="fs-sm text-muted">recent activities</div>
            </div>
            <div>
                <div class="fs-lg">Forum</div>
                <div class="fs-sm text-muted">recent posts & comments</div>
            </div>
            <div>
                <div class="fs-lg">Shopping Mall</div>
                <div class="fs-sm text-muted">Create Items, View Orders, ...</div>
            </div>
            <div>
                <div class="fs-lg">In App Purchase</div>
                <div class="fs-sm text-muted">Purchases & stats</div>
            </div>
        </div>
    </div>
    <div class="container">


        <div class="container menu mt-3">
            <a href="/?p=admin.index&w=user/admin-user-list"><?=ln('users', ln(['en' => 'Users', 'ko' => '사용자']))?></a>
            <a href="/?p=admin.index&w=category/admin-category-list"><?=ln('category', ln(['en' => 'Category', 'ko' => '카테고리']))?></a>
            <a href="/?p=admin.index&w=post-list/admin-post-list"><?=ln(['en' => 'Posts', 'ko' => '글'])?></a>
            <a
            <a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall"><?=ln(['en' => 'Shopping Mall', 'ko' => '쇼핑몰'])?></a>
            <a
            <a
        </div>


        <div class="content mt-3">
            <?php
            if ( in('w') ) include widget(in('w'));
            else include theme()->file('admin/dashboard');
            ?>
        </div>
    </div>
</section>
