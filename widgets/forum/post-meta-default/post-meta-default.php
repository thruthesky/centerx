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
        <img class="mr-3" style="height: 70px; width: 70px; border-radius: 50px;" src="<?= $user['photoUrl'] ?>" />
    <?php } else { ?>
        <div class="mr-3" style="height: 70px; width: 70px; border-radius: 50px; background-color: grey"> </div>
    <?php } ?>
    <div class="meta">
        <div><b><?= $post->user()->name == null ? 'No name' : $post->user()->name ?></b></div>
        <div class="text-muted">
            <?= date('r', $post->createdAt) ?>
        </div>
        <div class="text-muted">
            <?= $post->subcategory ? "<span class='badge badge-info'>{$post->subcategory}</span> " : "" ?>
            No. <?= $post->idx ?>
        </div>
    </div>
</div>