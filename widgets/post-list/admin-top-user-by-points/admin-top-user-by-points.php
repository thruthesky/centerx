<?php

/**
 * @type admin
 */
?>
<section class="p-4 overflow-hidden" id="admin-top-user-by-point" style="height: 24rem">
    <div class="text-muted fs-sm"><?= number_format(user()->count()) ?> users</div>
    <h5 class="mb-4 fw-700">Top most user by points</h5>
    <?php
    foreach (user()->search(where: "point>0", order: 'point', limit: 4) as $user) {
    ?>
        <div class="d-flex mb-3">
            <div class="rounded-circle hw-54x54" style="background-color: grey;">
            </div>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?= $user->name ?>(<?= $user->idx ?>)</strong></span><br>
                <span><?= $user->point ?></span>
            </div>
        </div>
    <?php } ?>
</section>