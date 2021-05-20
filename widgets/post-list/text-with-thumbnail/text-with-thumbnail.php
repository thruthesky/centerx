<?php

/**
 * @name Text with thumbnail
 */


$o = getWidgetOptions();
$post = $o['post'];

$fileIdxs = explode(",", $post->files);
?>


<div class="p-1">
  <img class="w-100" src="<?= files($fileIdxs[0])->url ?>">

  <?= $post->title ?>

</div>