<?php

/**
 * @size wide
 * @options Array(PostTaxonomy) 'posts', int 'normalImageHeight', int 'tallImageHeight'
 * @dependencies none
 */
$op = getWidgetOptions();
$posts = $op['posts'] ?? [];

$normalImageHeight = $op['normalImageHeight'] ?? 150;
$tallImageHeight = $op['tallImageHeight'] ?? 300;

if (empty($posts)) $posts = postMockData(10, photo: true);
?>


<div class="gallery-list-view">
  <?php if (count($posts)) { ?>
    <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "gutter": 5, "percentPosition": true, "horizontalOrder": true  }'>

      <?php
      $_gi = 0;
      foreach ($posts as $post) {
        if (!count($post->files())) continue;
        $_gi++;
        $isEven = $_gi % 2 === 0;
        $imageHeight = $isEven ? $tallImageHeight : $normalImageHeight;
      ?>
        <div class="grid-item <?= $isEven ? 'grid-item--height2' : '' ?>">
          <div class="image-holder">
            <?php include widget('post/photo-with-one-line-text-at-bottom', ['post' => $post, 'imageHeight' => $imageHeight]); ?>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <?php include widget('post-list/empty-post-list'); ?>
  <?php } ?>
</div>

<style>
  .grid-item {
    float: left;
    margin-bottom: 5px;
    width: 32.5%;
    height: <?= $normalImageHeight + 32 ?>px;
    /* border: 1px black solid; */
  }

  .grid-item--height2 {
    height: <?= $tallImageHeight + 32 ?>px;
  }
</style>

<?php js('/etc/js/masonry-4.2.2.js', 1) ?>