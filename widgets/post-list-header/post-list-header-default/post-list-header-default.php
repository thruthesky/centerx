<?php

$o = getWidgetOptions();
/**
 * @name Default Post List Header
 */
$category = $o['category'];

?>

<style>
    .bg-skyblue {
        background: #caf9ff;
    }
</style>

<div class="d-flex align-items-center p-2 mb-2 bg-skyblue white">
    <div class="mr-2"><?= ek('Categories:', '@T Categories:') ?></div>
    <?php if ($category->exists) { ?>
        <div>
            <a class="btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">All</a>
            <?php foreach ($category->subcategories as $cat) { ?>
                <a class="btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>&lsub=<?= $cat ?>"><?= $cat ?></a>
            <?php } ?>
        </div>
    <?php } ?>

    <span class="flex-grow-1"></span>
    <a class="btn btn-sm btn-success" href="/?p=forum.post.edit<?= inCategoryId() ?><?= inSubcategory() ?><?= inLsub() ?>">
        <?= ek('Create', '글 쓰기') ?>
    </a>
</div>