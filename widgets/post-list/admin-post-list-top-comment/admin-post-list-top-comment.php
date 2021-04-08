<?php
$past7days = time() - 7 * 60 * 60 * 24;
//$q = "SELECT userIdx, COUNT(*) as comments FROM " . DB_PREFIX . POSTS . " WHERE createdAt>$past7days AND parentIdx>0 GROUP BY userIdx ORDER BY comments DESC LIMIT 5";
$q = "SELECT userIdx, COUNT(*) as comments FROM " . DB_PREFIX . POSTS . " WHERE createdAt>$past7days GROUP BY userIdx ORDER BY comments DESC LIMIT 5";
$rows = db()->get_results($q, ARRAY_A);

$users = [];
foreach( $rows as $row ) {
    $user = user($row[USER_IDX])->profile();
    $user[COMMENTS] = $row[COMMENTS];
    $users[] = $user;
}
?>

<section class="p-4 overflow-hidden" id="admin-post-list-summary" style="height: 23.5rem">
    <h6 class="text-muted">No of comments for 7 days.</h6>
    <h5 class="mb-4">Top most users by comments</h5>

    <?php foreach ($users as $user) { ?>
        <div class="d-flex mb-3">
            <div class="rounded-circle hw-54x54" style="background-color: lightgrey;">
            </div>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?=$user[NAME]?>(<?=$user[IDX]?>)</strong></span><br>
                <span><?=$user[COMMENTS]?></span>
            </div>
        </div>
    <?php } ?>
</section>