<?php

/**
 * @name Default Post List Header
 */
$o = getWidgetOptions();
$category = $o['category'];

?>


<section class="post-list-header-default p-2 px-lg-0">
    <div class="d-flex justify-content-end flex-wrap">
        <?php if ($category->exists) { ?>
            <div class="px-2">
                <span class="m-1 text-uppercase font-weight-bold"><?= $category->id ?></span>
                <?php if ($category->subcategories) { ?>
                    <a class="m-1 btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">All</a>
                    <?php foreach ($category->subcategories as $cat) { ?>
                        <a class="m-1 btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>"><?= $cat ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <span class="d-md-block flex-grow-1"></span>
        <div class="d-flex align-items-center mr-2 p-1">
            <span class="mr-2">
                <?php include widget('push-notification/push-notification-icon', ['topic' => NOTIFY_POST . $category->id, 'label' => ln('post')]) ?>
            </span>
            <span>
                <?php include widget('push-notification/push-notification-icon',  ['topic' => NOTIFY_COMMENT . $category->id, 'label' => ln('comment')]) ?>
            </span>
            <span>
                <a class="btn btn-sm btn-success" href="<?= postEditUrl(in(CATEGORY_ID), in('subcategory')) ?>" <?= hook()->run(HOOK_POST_CREATE_BUTTON_ATTR) ?>>
                    <?= ln('post_create') ?>
                </a>
            </span>
        </div>
    </div>
</section>