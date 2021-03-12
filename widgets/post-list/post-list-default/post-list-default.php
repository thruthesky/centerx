<?php
/**
 * @name Default Post List Style
 */

$categoryId = in(CATEGORY_ID);


?>

<a class="btn btn-primary" href="/?p=forum.post.edit&categoryId=<?=in(CATEGORY_ID)?>">Create</a>

<?php
    $posts = post()->search(where: "parentIdx=0 AND categoryId=<$categoryId>");
?>

<?php foreach( $posts as $post ) {
    ?>
    <h2><a href="<?=$post['path']?>">No. <?=$post[IDX]?> <?=$post[TITLE]?></a></h2>

<?php } ?>


