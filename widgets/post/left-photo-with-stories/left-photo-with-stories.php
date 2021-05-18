<?php
/**
 * @size wide
 * @options 'categoryId'
 * @description Get a photo that has photo from the category and display as primary. and Get 5 more posts to display texts.
 * @dependency none
 */

$op = getWidgetOptions();



if ( isset($op['categoryId']) ) {

//    $posts = post()->latest()
    $limit = $op['limit'] ?? 5;
    $categoryId = $op['categoryId'];

    $posts = post()->latest(categoryId: $op['categoryId'] ?? $categoryId, limit: $limit);

// default image if first story post doesn't have image
    $src = "/widgets/post/left-photo-with-stories/panda.jpg";
    if ( !empty($posts) && $posts[0] && !empty($posts[0]->files())) {
        $src = thumbnailUrl($posts[0]->files()[0]->idx, 300, 200);
    }
}
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