<?php
$total_post = post()->count();
?>

<section class="p-4 overflow-hidden" id="admin-post-list-summary" style="height: 23.5rem">
    <h6 class="text-muted">Total number posts: <?= $total_post ?></h6>
    <h5 class="mb-4">Recent Posts</h5>

    <?php foreach (post()->search() as $post) { ?>
        <div class="d-flex mb-3">
            <div class="rounded-circle hw-54x54" style="background-color: grey;">
            </div>
            <div class="text-overflow-ellipsis ml-3">
                <span><strong><?=$post->title?> asd asd asd sad sadasdsadasd asd </strong></span><br>
                <span><?=$post->content?></span>
            </div>
        </div>
    <?php } ?>
</section>