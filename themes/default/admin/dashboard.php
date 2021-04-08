<?php



?>
<style>
    .w-33 {
        width: 33%;
    }
</style>

<div class="d-flex mb-3">
    <div class="w-33 mr-3">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-recent-summary'); ?>
        </div>
    </div>
    <div class="w-33 mr-3">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-recent-summary'); ?>
        </div>
    </div>
    <div class="w-33">
        <div class="mb-3 bg-white rounded">
            <?php include widget('point/admin-point-setting-summary'); ?>
        </div>
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-summary'); ?>
        </div>
    </div>
</div>
<div class="bg-white rounded">
    <?php include widget('statistic/admin-statistic-graph'); ?>
</div>

