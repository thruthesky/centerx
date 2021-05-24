<?php

/**
 * @type admin
 */
?>
<section class="p-4 overflow-hidden" data-cy="admin-post-list-recent-summary-widget" style="height: 24rem">

    <div class="text-muted fs-sm"><?= ln(['en' => 'Total number posts', 'ko' => '전체 글 수']) ?>: <?= post()->count() ?></div>
    <h6 class="mt-2 mb-4 fw-700"><?= ln(['en' => 'Recent Posts', 'ko' => '최근 글 목록']) ?></h6>

    <?php foreach (post()->latest(limit: 4) as $post) {
        $user = user($post->userIdx)->shortProfile();
    ?>
        <div class="d-flex mb-3">
            <?php if ($user['photoUrl']) { ?>
                <img class="mr-3 hw-50x50 border-radius-50" src="<?= $user['photoUrl'] ?>" />
            <?php } else { ?>
                <div class="mr-3 hw-50x50 border-radius-50" style="background-color: grey"> </div>
            <?php } ?>
            <div class="text-overflow-ellipsis ml-2">
                <a href="<?= $post->url ?>"><strong>No. <?= $post->idx ?> <?= $post->title ?></strong></a>
                <div class="mt-1 fs-xs"><?= $post->subcategory ? "[{$post->subcategory}] " : "" ?><?= date('r', $post->createdAt) ?></div>
            </div>
        </div>
    <?php } ?>
</section>