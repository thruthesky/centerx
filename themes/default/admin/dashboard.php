<div class="row mb-4">
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
        <div class="d-flex flex-column justify-content-between h-100">
            <div class="bg-white rounded">
                <?php include widget('point/admin-point-setting-summary'); ?>
            </div>
            <div class="bg-white rounded">
                <?php include widget('post-list/admin-post-list-summary', ['categoryId' => 'qna', 'limit' => 7]); ?>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
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

<div class="row mb-4">
    <div class="col-12">
        <div class="bg-white rounded">
            <?php include widget('statistic/admin-statistic-records'); ?>
        </div>
    </div>
</div>

