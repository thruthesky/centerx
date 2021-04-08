<?php
$total_post = post()->count();
$now = time();
$past = $now - 60*60*24*7;

$count_comments = comment()->count(where:"createdAt<=$now AND createdAt>=$past");

?>

<section class="p-4 overflow-hidden" id="admin-post-list-summary" style="height: 23.5rem">
    <h6 class="text-muted">Total number posts: <?= $count_comments ?></h6>
    <h5 class="mb-4">Top most users by comments</h5>

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