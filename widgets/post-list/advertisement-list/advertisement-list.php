<?php
/**
 * @name 광고 - 목록
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];
if ( empty($posts) ) return include widget('post-list/empty-post-list');
?>
<section class="post-list-default p-2 px-lg-0">
    <div>
        <?php
            foreach ($posts as $post) {
                $post = post(idx: $post->idx);
                ?>
                <div class="d-flex">
                    <a href="<?= $post->url ?>" style="text-decoration: none">
                        <div class="bold">No. <?= $post->idx ?> -
                            <?=$post->title?>
                        </div>
                        <div class="mt-1 text-muted">
                            <?= $post->subcategory ? "<span class='badge badge-info'> {$post->subcategory} </span>" : "" ?>
                            [<?=$post->categoryId()?>] <?= $post->shortDate ?>
                        </div>
                    </a>
                </div>
                <hr>
            <?php } ?>
    </div>
</section>

