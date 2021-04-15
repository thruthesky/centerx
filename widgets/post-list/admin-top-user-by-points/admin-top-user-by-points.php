<?php

/**
 * @type admin
 */
?>
<section class="p-4 overflow-hidden" id="admin-top-user-by-point" style="height: 24rem">
    <div class="text-muted fs-sm"><?= number_format(user()->count()) ?> <?= ek('users', '@T users') ?></div>
    <h6 class="mt-2 mb-4 fw-700"><?= ek('Top most user by points', '@T Top most user by points') ?></h6>
    <?php
    foreach (user()->search(where: "point>0", order: 'point', limit: 4) as $user) {
    ?>
        <div class="d-flex mb-3">
            <div class="rounded-circle hw-50x50" style="background-color: grey;">
            </div>
            <div class="text-overflow-ellipsis ml-4">
                <div><strong><?= empty($user->name) ? 'No name' : $user->name ?></strong> <small>(ID. <?= $user->idx ?>)</small></div>
                <div class="mt-1"><?= $user->point ?> <?= ek('Points', '@T Points') ?></div>
            </div>
        </div>
    <?php } ?>
</section>