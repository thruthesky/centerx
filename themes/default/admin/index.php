<?php
if ( admin() == false ) jsBack('You are not admin');
?>
<style>
    .title {
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 1rem;
        background-color: #eeede7;
    }
</style>
<section style="margin: 0 auto; width: 1024px;">
    <h1 class="title">Admin Page</h1>
    <a href="/?p=admin.index&w=user/admin-user-list">User</a>
    <a href="/?p=admin.index&w=category/admin-category-list">Category</a>
    <a href="/?p=admin.index&w=post-list/admin-post-list">Posts</a>
    <a href="/?p=admin.index&w=point/admin-point-setting">Point Setting</a>
    <a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall">Mall</a>
    <a href="/?p=admin.index&w=setting/admin-setting">Settings</a>
    <hr>
    <?php
    include widget(in('w') ?? 'user/admin-user-list');
    ?>
</section>
