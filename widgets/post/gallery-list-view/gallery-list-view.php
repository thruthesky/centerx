<?php

/**
 * @size wide
 * @options Array(PostTaxonomy) 'posts'
 * @dependencies none
 */
$op = getWidgetOptions();
$posts = $op['posts'] ?? [];
if (empty($posts)) $posts = postMockData(10, photo: true);
?>


<div class="gallery-list-view">
  <?php if (count($posts)) { ?>
    <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "gutter": 10, "percentPosition": true  }'>

      <?php
      foreach ($posts as $post) {
        if (!count($post->files())) continue;
      ?>
        <div class="grid-item">
          <a href="<?= $post->url ?>">
            <img class="w-100" src="<?= $post->files()[0]->url ?>" alt="">
            <div class="text-truncate"><?= $post->title ?></div>
          </a>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <?php include widget('post-list/empty-post-list'); ?>
  <?php } ?>
</div>

<style>
  .grid-item {
    margin-bottom: 5px;
    width: 32%;
  }

  .grid-item a {
    text-decoration: none;
    color: black;
  }
</style>

<?php js('/etc/js/masonry-4.2.2.js', 1) ?>