<?php

/**
 * @type admin
 */
?>
<section class="p-4 overflow-hidden" id="admin-top-user-by-point" style="height: 24rem">
    <div class="text-muted fs-sm"><?= ek(' ', '사용자 수: ') ?><?= number_format(user()->count()) ?> <?= ek('users', ' ') ?></div>
    <h6 class="mt-2 mb-4 fw-700"><?= ek('Top most user by points', '포인트가 많은 사용자 수') ?></h6>
    <?php
    foreach (user()->search(where: "point>0", order: 'point', limit: 4, object: true) as $user) {
    ?>
        <div class="d-flex mb-3">
            <?php if (user($user->idx)->shortProfile()['photoUrl']) { ?>
                <img class="mr-3 hw-50x50 border-radius-50" src="<?= user($user->idx)->shortProfile()['photoUrl'] ?>" />
            <?php } else { ?>
                <div class="mr-3 hw-50x50 border-radius-50" style="background-color: grey"> </div>
            <?php } ?>
            <div class="text-overflow-ellipsis ml-4">
                <div><strong><?=$user->nicknameOrName?></strong> <small>(ID. <?= $user->idx ?>)</small></div>
                <div class="mt-1"><?= $user->point ?> <?= ek('Points', '포인트') ?></div>
            </div>
        </div>
    <?php } ?>
</section>