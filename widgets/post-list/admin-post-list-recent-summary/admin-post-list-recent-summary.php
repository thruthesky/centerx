<?php

/**
 * @type admin
 */
?>
<section class="p-4 overflow-hidden" id="admin-post-list-recent-summary" style="height: 24rem">

    <div class="text-muted fs-sm">Total number posts: <?= post()->count() ?></div>
    <h5 class="mb-4 fw-700">Recent Posts</h5>

    <?php foreach (post()->latest(null, 1, 4) as $post) {
        $user = user($post->userIdx);
    ?>
        <div class="d-flex mb-3">
            <?php if ($user->photoUrl) { ?>
                <img class="mr-3 hw-50x50 border-radius-50" src="<?= $user->photoUrl ?>" />
            <?php } else { ?>
                <div class="mr-3 hw-50x50 border-radius-50" style="background-color: grey"> </div>
            <?php } ?>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?= $post->title ?></strong></span><br>
                <span><?= $post->content ?></span>
            </div>
        </div>
    <?php } ?>
</section>