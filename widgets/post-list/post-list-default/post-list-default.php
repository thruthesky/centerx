<?php
/**
 * @name Default Post List Style
 */
global $posts;
?>

<a class="btn btn-primary" href="/?p=forum.post.edit&categoryId=<?=in(CATEGORY_ID)?>">Create</a>

<?php

?>

<?php foreach( $posts as $post ) {
    ?>
    <h2><a href="<?=$post->url?>">No. <?=$post->idx?> <?=$post->title?></a></h2>

<?php } ?>


