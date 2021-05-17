<?php




?>

<section class="post-list-text-with-thumbnail row">
  <?php
  foreach (post()->search(limit: 5) as $post) {
  ?>
    <div class="col-6 p-0 ">
      <?php include widget('post-list/text-with-thumbnail', ['post' => post($post['idx'])]); ?>
    </div>
  <?php
  }
  ?>
</section>