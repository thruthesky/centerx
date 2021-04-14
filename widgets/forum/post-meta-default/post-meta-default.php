<?php
$o = getWidgetOptions();

/**
 * @var Comment|Post $parent
 */
$post = $o['post'];
$user = user($post->userIdx)->shortProfile();
?>


<div class="d-flex">
    <!-- TODO: user profile photo -->
    <?php if ($user['photoUrl']) { ?>
        <img class="mr-3" style="height: 60px; width: 60px; border-radius: 50px;" src="<?= $user['photoUrl'] ?>" />
    <?php } else { ?>
        <div class="mr-3" style="height: 60px; width: 60px; border-radius: 50px; background-color: grey"> </div>
    <?php } ?>
    <div class="meta">
        <div class="mt-1"><b><?= $post->user()->name ?></b> - No. <?= $post->idx ?></div>
        <div class="mt-1"><?= $post->subcategory ? "[{$post->subcategory}] " : "" ?><?= date('r', $post->createdAt) ?></div>
    </div>
</div>