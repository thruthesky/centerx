<?php
$users = user()->search(where: "point>0", order: 'point', limit: 5);

?>

<section class="p-4 overflow-hidden" id="admin-post-list-summary" style="height: 23.5rem">
    <h6 class="text-muted"><?=number_format(user()->count())?> users</h6>
    <h5 class="mb-4">Top most user by points</h5>
    <?php
    foreach (user()->search(where: "point>0", order: 'point', limit: 5) as $user) {
        ?>
        <div class="d-flex mb-3">
            <div class="rounded-circle hw-54x54" style="background-color: grey;">
            </div>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?=$user->name?>(<?=$user->idx?>)</strong></span><br>
                <span><?=$user->point?></span>
            </div>
        </div>
    <?php } ?>
</section>