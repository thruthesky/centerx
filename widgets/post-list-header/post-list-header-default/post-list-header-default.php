<?php

/**
 * @name Default Post List Header
 */
$o = getWidgetOptions();
$category = $o['category'];

?>


<section class="post-list-header-default px-2 px-lg-0">
    <div class="d-flex align-items-center p-2">

        <?php if ($category->exists) { ?>
            <div class="mr-2 text-uppercase font-weight-bold"><?= $category->id ?></div>
            <?php if ($category->subcategories) { ?>
                <div>
                    <a class="btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">All</a>
                    <?php foreach ($category->subcategories as $cat) { ?>
                        <a class="btn btn-sm btn-info" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>"><?= $cat ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>

        <span class="flex-grow-1"></span>
        <span class="mr-3">
            <?php include widget('push-notification/push-notification-icon', ['topic' => NOTIFY_POST . $category->id, 'label' => ln('post')]) ?>
        </span>
        <span class="mr-3">
            <?php include widget('push-notification/push-notification-icon',  ['topic' => NOTIFY_COMMENT . $category->id, 'label' => ln('comment')]) ?>
        </span>

        <a class="btn btn-sm btn-success" href="<?= postEditUrl(in(CATEGORY_ID), in('subcategory')) ?>" <?= hook()->run(HOOK_POST_CREATE_BUTTON_ATTR) ?>>
            <?= ln('post_create') ?>
        </a>

    </div>
</section>