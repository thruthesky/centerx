<?php
$o = getWidgetOptions();

/**
 * @var CommentTaxonomy|PostTaxonomy $post
 */
$post = $o['post'];

?>


<div class="post-meta-default d-flex">
    <?php include widget('user/user-avatar', ['user' => $post->user(), 'size' => '70']) ?>
    <div class="meta">
        <div><b><?=$post->user()->nicknameOrName?></b></div>
        <div class="text-muted">
            <?=ln('date')?>: <?=$post->shortDate?>
            <?=ln('no_of_views')?>: <?=$post->noOfViews?>
        </div>
        <div class="text-muted">
            <?= $post->subcategory ? "<span class='badge badge-info'>{$post->subcategory}</span> " : "" ?>
            <?php if ( $_ = hook()->run('post-meta-3rd-line', $post) ) echo $_; else { ?>
                No. <?= $post->idx ?>
            <?php } ?>
        </div>
    </div>
</div>


