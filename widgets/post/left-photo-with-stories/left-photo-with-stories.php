<?php

/**
 * @size wide
 * @options 'title' & 'limit' & 'categoryId'.
 * @dependency none
 */

$op = getWidgetOptions();

$limit = $op['limit'] ?? 5;
$categoryId = 'discussion';

// default image if first story post doesn't have image
$src = "/widgets/post/left-photo-with-stories/panda.jpg";

if (isset($op['categoryId'])) {
  $categoryId = $op['categoryId'];
}

$posts = [];
if (category($categoryId)->exists == true) {
  $posts = post()->latest(categoryId: $categoryId, limit: $limit);
}

if (empty($posts)) {
  $post = post();
  $post->updateMemoryData('title', 'What a lovely dog. What is your name? This is the sample title! This is very long text... Make it two lines only!');
  $post->updateMemoryData('content', 'What a lovely dog. What is your name? This is the sample content! This is very long text... Make it two lines only!');
  $post->updateMemoryData('url', "javascript:alert('This is a mock data. Post data is not given!');");
  $post->updateMemoryData('src', "/widgets/post/photo-with-text-at-bottom/panda.jpg");
  $posts = array_fill(0, $limit, $post);
}

if ( !empty($posts[0]->files()) ) {
  $src = thumbnailUrl($posts[0]->files()[0]->idx, 300, 200);
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