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
        $user = user($post->userIdx)->shortProfile();
    ?>
            <div class="d-flex w-100">
                <?php if ($user['photoUrl']) { ?>
                    <img class="mr-3" style="height: 50px; min-width: 50px; border-radius: 50px;" src="<?= $user['photoUrl'] ?>" />
                <?php } else { ?>
                    <div class="mr-3" style="height: 50px; min-width: 50px; border-radius: 50px; background-color: grey"> </div>
                <?php } ?>
                <div class="w-100">
                    <a href="<?= $post->url ?><?= lsub(true) ?>">No. <?= $post->idx ?> <?= $post->title ?></a>
                    <div class="mt-1">
                        <?= $post->subcategory ? "<span class='badge badge-info'> {$post->subcategory} </span>" : "" ?> <?= date('r', $post->createdAt) ?>
                    </div>
                </div>
            </div>
            <hr>
    <?php }
    } else { ?>
    
    <div class="pb-3 d-flex justify-content-center">No posts yet ..</div>

    <?php } ?>
</section>