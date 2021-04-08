<?php
//$now = time();
//$past = mktime(0,0,0, date('m',$now), date('d',$now) - 7);

$past7days = time() - 7 * 60 * 60 * 24;

$rows = db()->get_results("SELECT userIdx, COUNT(*) as comments FROM " . DB_PREFIX . 'posts' . " WHERE createdAt>$past7days GROUP BY userIdx ORDER BY comments DESC LIMIT 5", ARRAY_A);
d($rows);


//$top_comments = comment()->search(select: 'userIdx, COUNT(userIdx)' ,where:"createdAt<=$now AND createdAt>=$past GROUP BY userIdx", order: 'COUNT(userIdx)');


?>

<section class="p-4 overflow-hidden" id="admin-post-list-summary" style="height: 23.5rem">
<<<<<<< HEAD
    <h6 class="text-muted">Total number posts: <?= $count_comments ?></h6>
    <h5 class="mb-4">Top most users by comments</h5>
=======
<!--    <h6 class="text-muted">Total number posts: --><?//= $count_comments ?><!--</h6>-->
    <h5 class="mb-4">Recent Posts</h5>
>>>>>>> 811c8adda86778688f51770f1daa7ac26ed1c49c

    <?php foreach (post()->latest(null, 1, 4) as $post) { ?>
        <div class="d-flex mb-3">
            <div class="rounded-circle hw-54x54" style="background-color: grey;">
            </div>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?=$post->title?></strong></span><br>
                <span><?=$post->content?></span>
            </div>
        </div>
    <?php } ?>
</section>