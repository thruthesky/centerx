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

    <a class="btn btn-primary" href="/?p=forum.post.edit<?=inCategoryId()?><?=inSubcategory()?><?=inLsub()?>">
        <?=ek('Create', '글 쓰기')?>
    </a>
    <?php if ( $category->exists ) { ?>
    <div>
        <a class="btn btn-link" href="/?p=forum.post.list&categoryId=<?=in(CATEGORY_ID)?>">All</a>
        <?php foreach( $category->subcategories as $cat ) { ?>
            <a class="btn btn-link" href="/?p=forum.post.list&categoryId=<?=in(CATEGORY_ID)?>&subcategory=<?=$cat?>&lsub=<?=$cat?>"><?=$cat?></a>
        <?php } ?>
    </div>
    <?php } ?>
    <?php foreach( $posts as $post ) {
        ?>
        <hr>
        <a href="<?=$post->url?><?=lsub(true)?>">
            No. <?=$post->idx?> <?=$post->title?>
        </a>
    <?php } ?>

</section>
