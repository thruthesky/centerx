<?php
$o = getWidgetOptions();

/**
 * @var Comment|Post $post
 */
$post = $o['post'];
?>


<div class="d-flex">
    <!-- TODO: user profile photo -->
    <?php include widget('user/user-avatar', ['photoUrl' => $post->user()->shortProfile()['photoUrl'], 'size' => '70']) ?>
    <div class="meta">
        <div><b><?=$post->user()->nicknameOrName?></b></div>
        <div class="text-muted">
            <?= date('r', $post->createdAt) ?>
        </div>
        <div class="text-muted">
            <?= $post->subcategory ? "<span class='badge badge-info'>{$post->subcategory}</span> " : "" ?>
            No. <?= $post->idx ?>
        </div>
    </div>
</div>