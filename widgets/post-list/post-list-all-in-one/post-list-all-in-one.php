<?php

/**
 * @name All In One: Create, List, View
 */

$o = getWidgetOptions();
$posts = $o['posts'];


?>
<div class="d-none border-bottom border-top my-3" :class="{'d-block': showPostForm}">
    <?php include widget('post-edit/post-edit-default'); ?>
</div>
<section class="post-list-all-in-one">
    <?php
    if (count($posts)) {
        foreach ($posts as $post) { ?>
            <div>
                <?php include widget('post-view/post-view-default', ['post' => $post]); ?>
            </div>
        <?php }
    } else { ?>
        <?php include widget('post-list/empty-post-list'); ?>
    <?php } ?>
</section>
