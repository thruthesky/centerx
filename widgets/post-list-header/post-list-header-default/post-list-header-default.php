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

<div class="d-flex align-items-center p-2 bg-skyblue white" 
    style="border-top-left-radius: 8px; 
    border-top-right-radius: 8px;">
    <h5 class="mb-0 mr-2"><?= strtoupper($category->id) . ' :' ?></h5>
    <?php if ($category->exists) { ?>
        <div>
            <a class="btn btn-sm <?= empty(in('lsub')) ? 'btn-info' : ''?>" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">All</a>
            <?php foreach ($category->subcategories as $cat) { ?>
                <a class="btn btn-sm  <?= in('lsub') == $cat ? 'btn-info' : ''?>" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>&lsub=<?= $cat ?>"><?= $cat ?></a>
            <?php } ?>
        </div>
    <?php } ?>

    <span class="flex-grow-1"></span>
    <a class="btn btn-sm btn-success" href="/?p=forum.post.edit<?= inCategoryId() ?><?= inSubcategory() ?><?= inLsub() ?>">
        <?= ek('Create', '글 쓰기') ?>
    </a>
</div>