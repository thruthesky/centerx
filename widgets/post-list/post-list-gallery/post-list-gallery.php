<?php

/**
 * @name Gallery
 * @option Array of PostTaxonomy posts, posts should contain atleast 1 image.
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>


<div class="post-list-gallery px-2 px-lg-0 mb-3">
  <?php include widget('post/gallery-list-view', ['posts' => $posts]) ?>
</div>