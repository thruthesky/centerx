<?php
if ( admin() == false ) jsBack('You are not admin');
?>
<style>
    .layout {
        margin: 0 auto; width: 1024px;
    }
    .layout .menu {
        padding-left: .5em;
        border-radius: 1rem;
        background-color: #583d3d;
    }
    .layout .menu a {
        display: inline-block;
        padding: .5em .25em;
        color: white;
    }
    .title {
        padding: 1rem;
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
        background-color: #f2f3f2;
    }
    .layout .content {
        padding: 1rem;
        border-radius: 1rem;
        background-color: #eeede7;
    }
    .menu a[href*="<?=in('w')?>"] {
        color: yellow !important;
    }
</style>
<section class="layout">
    <h1 class="title"><a href="/?p=admin.index">있수다! 관리자 페이지</a></h1>
    <div class="menu mt-3">
        <a href="/?p=admin.index&w=user/admin-user-list"><?=ln('users', ln(['en' => 'Users', 'ko' => '사용자']))?></a>
        <a href="/?p=admin.index&w=category/admin-category-list"><?=ln('category', ln(['en' => 'Category', 'ko' => '카테고리']))?></a>
        <a href="/?p=admin.index&w=post-list/admin-post-list"><?=ln(['en' => 'Posts', 'ko' => '글'])?></a>
        <a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall"><?=ln(['en' => 'Shopping Mall', 'ko' => '쇼핑몰'])?></a>
        <a href="/?p=admin.index&w=setting/admin-translation"><?=ln(['en' => 'Translations', 'ko' => '언어화'])?></a>
        <a href="/?p=admin.index&w=setting/admin-setting"><?=ln(['en' => 'Settings', 'ko' => '설정'])?></a>
        <a href="/?p=admin.index&w=point/admin-point-setting"><?=ln(['en' => 'Point Setting', 'ko' => '포인트 설정'])?></a>
        <a href="/?p=admin.index&w=setting/upload-image&code=admin.app.about.setting"><?=ln(['en' => 'About Setting', 'ko' => '어바웃 설정'])?></a>
    </div>

    <div class="content mt-3">
        <?php
        if ( in('code') == 'admin.app.about.setting') {
            $admin_upload_title = '어바웃 페이지 사진 등록';
            $admin_upload_description = '앱 어바웃 페이지에 들어갈 사진을 업로드 해 주세요.';
        }
        if ( in('w') ) include widget(in('w'));
        else include theme()->file('admin/home');
        ?>
    </div>
</section>
