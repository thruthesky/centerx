<?php

/**
 * @type admin
 */
$past7days = time() - 7 * 60 * 60 * 24;
$q = "SELECT userIdx, COUNT(*) as comments FROM " . DB_PREFIX . POSTS . " WHERE createdAt>$past7days AND parentIdx!=0 GROUP BY userIdx ORDER BY comments DESC LIMIT 5";
//$q = "SELECT userIdx, COUNT(*) as comments FROM " . DB_PREFIX . POSTS . " WHERE createdAt>$past7days GROUP BY userIdx ORDER BY comments DESC LIMIT 5";
$rows = db()->get_results($q, ARRAY_A);

$users = [];
foreach ($rows as $row) {
    $user = user($row[USER_IDX])->profile();
    $user[COMMENTS] = $row[COMMENTS];
    $users[] = $user;
}
?>

<section class="p-4 overflow-hidden" id="admin-post-list-top-comment" style="height: 24rem; overflow: auto">

    <div class="text-muted fs-sm">No of comments for 7 days</div>
    <h5 class="mb-4 fw-700">Top most users by comments</h5>

    <?php foreach ($users as $user) { ?>
        <div class="d-flex mb-3">
            <div class="mr-3 hw-50x50 border-radius-50" style="background-color: grey"> </div>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?= $user[NAME] ?>(<?= $user[IDX] ?>)</strong></span><br>
                <span><?= $user[COMMENTS] ?></span>
            </div>
        </div>
    <?php } ?>
</section>