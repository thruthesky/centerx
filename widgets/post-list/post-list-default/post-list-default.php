<?php

/**
 * @name Default Post List Style
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];
$category = $o['category'];


?>
<!-- <section style="padding: 1rem 1rem 0 1rem; background-color: #efefef;"> -->
<div class="d-flex mb-3">
    <section class="mt-3 flex-grow-1">
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
        ?> <div class="card border-round p-2 mb-3">
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
                </div>
            <?php }
        } else { ?>
            <div class="mt-5 pb-3 d-flex justify-content-center"><?= ek('No posts yet ..', '@T No posts yet ..') ?></div>
        <?php } ?>
    </section>

    <section class="mt-3 ml-3" style="width: 150px;">
        <div class="card p-2">
            <?php if ($category->exists) { ?>
                <a class="btn btn-sm w-100 mb-2 <?= empty(in('lsub')) ? 'btn-info' : '' ?>" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>">
                    <?= ek('All Posts', '@T All Posts') ?>
                </a>
                <hr class="my-1">
                <?php foreach ($category->subcategories as $cat) { ?>
                    <a class="btn btn-sm w-100 mb-2 <?= in('lsub') == $cat ? 'btn-info' : '' ?>" href="/?p=forum.post.list&categoryId=<?= in(CATEGORY_ID) ?>&subcategory=<?= $cat ?>&lsub=<?= $cat ?>"><?= $cat ?></a>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
</div>