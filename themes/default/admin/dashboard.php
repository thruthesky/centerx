<?php



?>

<div class="row mb-3">
    <div class="col-4">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-top-user-by-points'); ?>
        </div>
    </div>
    <div class="col-4">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-recent-summary'); ?>
        </div>
    </div>
    <div class="col-4">
        <div class="mb-3 bg-white rounded">
            <?php include widget('point/admin-point-setting-summary'); ?>
        </div>
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-summary'); ?>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-4">
        <div class="bg-white rounded">
            <?php include widget('post-list/admin-post-list-top-comment'); ?>
        </div>
    </div>
    <div class="col-8">
        <div class="bg-white rounded">
            <?php include widget('statistic/admin-statistic-graph'); ?>
        </div>
    </div>
</div>

