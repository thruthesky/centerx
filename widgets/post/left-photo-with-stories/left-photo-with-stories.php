<?php
/**
 * @size wide
 * @options 'categoryId'
 * @description Get a photo that has photo from the category and display as primary. and Get 5 more posts to display texts.
 * @dependency none
 */

$op = getWidgetOptions();


$primary = null;
$posts = [];
if ( isset($op['categoryId']) ) {

    // Get primary post that has photo.
    $_posts = post()->latest(categoryId: $op['categoryId'], limit: 1);
    if ( count($_posts) ) $primary = $_posts[0];

    // Get first 5 posts excluding the primary post.
    $limit = $op['limit'] ?? 6;
    $categoryId = $op['categoryId'];
    $_posts = post()->latest(categoryId: $op['categoryId'], limit: $limit);
    foreach( $_posts as $post ) {
        if ( $post->idx != $primary->idx ) $posts[] = $post;
        if ( count($posts) == 5 ) break;
    }
}


//$src = "/widgets/post/left-photo-with-stories/panda.jpg";
//if ( !empty($posts) && $posts[0] && !empty($posts[0]->files())) {
//    $src = thumbnailUrl($posts[0]->files()[0]->idx, 300, 200);
//}

?>

<div class="left-photo-with-stories">
  <div class="section-image"><img src="<?= $src ?>"></div>
  <div class="stories">
    <?php foreach ($posts as $post) { ?>
      <div><a href="<?= $post->url ?>"><?= $post->title ?></a></div>
    <?php } ?>
  </div>
</div>

<style>
  .left-photo-with-stories {
    display: flex;
    width: 100%;
  }

  .left-photo-with-stories .section-image {
    width: 33%;
  }

  .left-photo-with-stories .section-image img {
    width: 100%;
  }

  .left-photo-with-stories .stories {
    width: 66%;
    margin-left: 8px;
  }

  .left-photo-with-stories .stories div {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>