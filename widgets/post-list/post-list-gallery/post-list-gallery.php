<?php

/**
 * @name Gallery
 * @option Array of PostTaxonomy posts, posts should contain atleast 1 image.
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>


<div class="post-list-gallery">
  <?php include widget('post/gallery-list-view', ['posts' => $posts, 'normalImageHeight' => 200, 'tallImageHeight' => 350]) ?>
</div>