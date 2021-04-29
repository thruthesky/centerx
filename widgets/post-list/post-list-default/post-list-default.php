<?php

/**
 * @name Default Post List Style
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];
$category = $o['category'];


?>
<section style="padding: 1rem 1rem 0 1rem; background-color: #efefef;">
    <?php
    if (!empty($posts)) {
        foreach ($posts as $post) {
    ?>
            <div class="d-flex w-100">
                <?php include widget('user/user-avatar', ['photoUrl' => $post->user()->shortProfile()['photoUrl'], 'size' => '75']) ?>
                <a href="<?= $post->url ?><?= lsub(true) ?>" class="w-100" style="text-decoration: none">
                    <div style="color: black; font-weight: 500; font-size: 1.2rem"><?= $post->title ?></div>
                    <div style="color: black; font-weight: 500"><?= empty($post->user()->shortProfile()['name']) ? 'No name' : $post->user()->shortProfile()['name'] ?></div>
                    <div class="text-muted">
                        <?= $post->subcategory ? "<span class='badge badge-info'> {$post->subcategory} </span>" : "" ?>
                        <?= ' - ' . 'No. ' . $post->idx ?>
                        <?= ' - ' . date('r', $post->createdAt) ?>
                    </div>
                </a>
            </div>
            <hr>
        <?php }
    } else { ?>
        <div class="pb-3 d-flex justify-content-center">No posts yet ..</div>
    <?php } ?>
</section>