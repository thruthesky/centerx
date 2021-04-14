<?php

/**
 * @name Default Post List Style
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];
$category = $o['category'];


?>
<section style="padding: 1rem; background-color: #efefef;">

    <div class="d-flex">

        <?php if ($category->exists) { ?>
            <div>
                <a class="btn btn-link" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">All</a>
                <?php foreach ($category->subcategories as $cat) { ?>
                    <a class="btn btn-link" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>&lsub=<?= $cat ?>"><?= $cat ?></a>
                <?php } ?>
            </div>
        <?php } ?>

        <span class="flex-grow-1"></span>
        <a class="btn btn-primary" href="/?p=forum.post.edit<?= inCategoryId() ?><?= inSubcategory() ?><?= inLsub() ?>">
            <?= ek('Create', '글 쓰기') ?>
        </a>
    </div>


    <?php foreach ($posts as $post) {
    $user = user($post->userIdx)->shortProfile();
    ?>
        <hr>
        <div class="d-flex">
            <?php if ($user['photoUrl']) { ?>
                <img class="mr-3" style="height: 50px; width: 50px; border-radius: 50px;" src="<?= $user['photoUrl'] ?>" />
            <?php } else { ?>
                <div class="mr-3" style="height: 50px; width: 50px; border-radius: 50px; background-color: grey"> </div>
            <?php } ?>
            <div>
                <a href="<?= $post->url ?><?= lsub(true) ?>">No. <?= $post->idx ?> <?= $post->title ?></a>
                <div class="mt-1"><?= $post->subcategory ? "[{$post->subcategory}] " : "" ?><?= date('r', $post->createdAt) ?></div>
            </div>
        </div>
    <?php } ?>

</section>