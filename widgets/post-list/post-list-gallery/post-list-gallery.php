<?php

/**
 * @name Gallery
 * @option Array of PostTaxonomy posts, posts should contain atleast 1 image.
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>

<section class="post-list-gallery p-1" style="border-radius: 16px; background-color: #f4f4f4;">
  <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "gutter": 5 }'>

    <?php
    $_gi = 0;
    foreach ($posts as $post) {
      $_gi++;
      $isEven = $_gi % 2 === 0;
      $imageHeight = $isEven ? 266 : 116;
    ?>
      <div class="grid-item <?= $isEven ? 'grid-item--height2' : '' ?>">
        <div class="image-holder">
          <?php include widget('post/photo-with-one-line-text-at-bottom', ['post' => $post, 'imageHeight' => $imageHeight]); ?>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<style>
  .grid-item {
    float: left;
    margin-bottom: 10px;
    width: 32.5%;
    height: 150px;
    /* border: 1px black solid; */
  }

  .grid-item--height2 {
    height: 300px;
  }
</style>

<?php js('/etc/js/masonry-4.2.2.js', 1) ?>