<?php
/**
 * @name Default Post List Style
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];



?>
<section class="post-list-default px-2 px-lg-0">
    <div style="padding: 1rem 1rem 0 1rem; background-color: #efefef;">
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post = post(idx: $post->idx);
                $user = user(idx: $post->userIdx);

                if ( in('categoryId') == null ) {
                    $_category = '('. $post->categoryId() . ')';
                } else {
                    $_category = '';
                }
        ?>
                <div class="d-flex">
                    <?php include widget('user/user-avatar', ['photoUrl' => $user->shortProfile()['photoUrl'], 'size' => '50']) ?>
                    <a href="<?= $post->url ?>" style="text-decoration: none">
                        <div style="color: black; font-weight: 500">No. <?= $post->idx ?> - <?= $post->title ?></div>
                        <div class="mt-1 text-muted">
                            <?=$_category?>
                            <?= $post->subcategory ? "<span class='badge badge-info'> {$post->subcategory} </span>" : "" ?>
                            <?= $post->shortDate ?>
                        </div>
                    </a>
                </div>
                <hr>
            <?php }
        } else { ?>
            <div class="pb-3 d-flex justify-content-center">No posts yet ..</div>
        <?php } ?>
    </div>
</section>

