<?php

/**
 * @name Gallery
 * @option Array of PostTaxonomy posts, posts should contain atleast 1 image.
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>

<section class="post-view-default p-3 mb-5" style="border-radius: 16px; background-color: #f4f4f4;">
  <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "gutter": 5 }'>

    <?php
    $_gi = 0;
    foreach ($posts as $post) {
      $_gi++;
      if ($_gi < 4 && $_gi / 2 === 1) {
        $imageHeight = 400; ?>
        <a class="grid-item grid-item--height2" href="<?= $post->url ?>">
          <img src="<?= thumbnailUrl($post->files()[0]->idx, height: $imageHeight, zoomCrop: true);  ?>">
          <div><?= $post->title ?></div>
        </a>
      <?php } else {
        $imageHeight = 200; ?>
        <a class="grid-item" href="<?= $post->url ?>">
          <img src="<?= thumbnailUrl($post->files()[0]->idx, height: $imageHeight, zoomCrop: true); ?>">
          <div><?= $post->title ?></div>
        </a>
      <?php } ?>
    <?php } ?>
  </div>
</section>

<style>
  .grid-item {
    position: relative;
    float: left;
    margin-bottom: 10px;
    width: 33%;
    height: 200px;
    border: 1px solid hsla(0, 0%, 0%, 0.5);
  }

  .grid-item img {
    width: 100%;
    height: 100%;
  }

  .grid-item div {
    position: absolute;
    overflow: hidden;
    height: 2em;
    bottom: 0;
    padding: .25em;
    font-weight: 500;
    font-size: 1em;
    background-color: wheat;
  }

  .grid-item--height2 {
    height: 410px;
  }
</style>

<?php js('/etc/js/masonry-4.2.2.js', 1) ?>