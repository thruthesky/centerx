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

<section class="post-list-header-default px-2 px-lg-0">
    <div class="d-flex align-items-center p-2"
         style="border-top-left-radius: 8px;
    border-top-right-radius: 8px;">

        <?php if ( $category->exists && $category->subcategories ) { ?>
            <div class="mr-2"><?= ek('Categories:', '카테고리:') ?></div>
            <div>
                <a class="btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">All</a>
                <?php foreach ($category->subcategories as $cat) { ?>
                    <a class="btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>&lsub=<?= $cat ?>"><?= $cat ?></a>
                <?php } ?>
            </div>
        <?php } ?>



        <span class="flex-grow-1"></span>
        <span class="mr-3" @click="forumNotification()">Notify <i class="fa fa-bell"></i></span>

        <a class="btn btn-sm btn-success" href="/?p=forum.post.edit<?= inCategoryId() ?><?= inSubcategory() ?><?= inLsub() ?>">
            <?= ek('Create', '글 쓰기') ?>
        </a>
    </div>
</section>

<script>
    mixins.push({
        data: {},
        methods: {
            forumNotification: function() {
                console.log("subscribe or unsubscribe")
            }
        }
    });
</script>