<?php
/**
 * @type admin
 */
?>
<section class="p-4 overflow-hidden" id="admin-post-list-recent-summary" style="height: 24rem">
    <h6 class="text-muted">Total number posts: <?= post()->count() ?></h6>
    <h5 class="mb-4">Recent Posts</h5>

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