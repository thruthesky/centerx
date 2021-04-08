<?php
/**
 * @name Default Post List Style
 */
global $posts;
?>
<section style="padding: 1rem; background-color: #efefef;">

    <a class="btn btn-primary" href="/?p=forum.post.edit&categoryId=<?=in(CATEGORY_ID)?>">
        <?=ek('Create', '글 쓰기')?>
    </a>
    <?php foreach( $posts as $post ) {
        ?>
        <hr>
        <a href="<?=$post->url?>">
            No. <?=$post->idx?> <?=$post->title?>
        </a>
    <?php } ?>

</section>
