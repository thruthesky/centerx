<?php

/**
 * @name Text with thumbnail post list
 */
$o = getWidgetOptions();
$posts = $o['posts'];
?>

<section class="post-list-default px-2 px-lg-0">
  <div style="padding: 1rem 1rem 0 1rem; background-color: #efefef;">
    <?php
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $post = post(idx: $post->idx);
        $user = user(idx: $post->userIdx);
        $src = '';
        if (!empty($post->files())) $src = thumbnailUrl($post->files()[0]->idx, 300, 200);
    ?>
        <div class="d-flex">
          <a href="<?= $post->url ?>" class="d-flex" style="width: 100%; font-size: 1em; text-decoration: none;">
            <?php if ($src) { ?> <img class="photo rounded mr-2" src="<?= $src ?>" style="width: 90px; height: 90px;"> <?php } ?>
            <div>
              <div class="overflow-hidden" style="max-height: 3em; color: black; font-weight: 500">
                <?= $post->title ?>
              </div>
              <div class="overflow-hidden" style="max-height: 3em; color: black">
                <?= $post->content ?>
              </div>
            </div>
          </a>
          <div class="d-block text-right" style="min-width: 100px;">
            <div><?= category($post->categoryIdx)->id ?></div>
            <div>79</div>
            <div><?= $post->shortDate ?></div>
          </div>
        </div>
        <hr>
      <?php }
    } else { ?>
      <div class="pb-3 d-flex justify-content-center">No posts yet ..</div>
    <?php } ?>
  </div>
</section>