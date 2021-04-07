<?php
$total_post = post()->count();



?>


<style>
    .fw-700 {
        font-weight: 700;
    }
</style>

<section class="d-flex h-100 p-3" id="admin-post-list-summary">
    <div>
        <div>Total number posts: <?=$total_post?></div>
        <h3>Recent Posts</h3>
        <div class="d-flex justify-content-start p-2 fw-700">
            <div class="py-3 overflow-hidden">
                <?php
                foreach( post()->search() as $post ) {
                    ?>
                    <div class="text-overflow-ellipsis">
                        <?=$post->title?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>