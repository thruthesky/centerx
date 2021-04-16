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
    $user = user($row[USER_IDX])->shortProfile();
    $user[COMMENTS] = $row[COMMENTS];
    $users[] = $user;
}
?>

<section class="p-4 overflow-hidden" id="admin-post-list-top-comment" style="height: 24rem; overflow: auto">

    <div class="text-muted fs-sm"><?= ek('No of comments for 7 days', '@T No of comments for 7 days') ?></div>
    <h6 class="mt-2 mb-4 fw-700"><?= ek('Top most users by comments', '@T Top most users by comments') ?></h6>

    <?php foreach ($users as $user) { ?>
        <div class="d-flex mb-3">
            <?php if ($user['photoUrl']) { ?>
                <img class="mr-3 hw-50x50 border-radius-50" src="<?= $user['photoUrl'] ?>" />
            <?php } else { ?>
                <div class="mr-3 hw-50x50 border-radius-50" style="background-color: grey"> </div>
            <?php } ?>
            <div class="text-overflow-ellipsis ml-2">
                <div><strong><?= $user[NAME] ?>(<?= $user[IDX] ?>)</strong></div>
                <div class="mt-1"><?= $user[COMMENTS] ?> <?= ek('comments', '@T comments') ?></div>
            </div>
        </div>
    <?php } ?>
</section>