<?php



?>
<style>
    .w-33 {
        width: 33%;
    }
</style>

<div class="d-flex">
    <div class="w-33 mr-5">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-top-user-by-points'); ?>
        </div>
    </div>
    <div class="w-33 mr-5">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-recent-summary'); ?>
        </div>
    </div>
    <div class="w-33">
        <div class="mb-5 bg-white rounded">
            <?php include widget('point/admin-point-setting-summary'); ?>
        </div>
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-summary'); ?>
        </div>
    </div>
</div>