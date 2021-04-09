<?php
$o = getWidgetOptions();
?>
<section id="admin-post-list-summary">
    <div class="d-flex justify-content-start py-3 px-4 fw-700">
        <div class="pr-4">
            <div class="d-flex justify-content-center align-items-center hw-54x54 rounded-circle bg-skyblue color-lightblue">Event</div>
        </div>
        <div class="py-3 overflow-hidden">
            <?php
            foreach( post()->search(where: "categoryId=<$o[categoryId]>", limit: $o['limit']) as $post ) {
                ?>
                    <div class="text-overflow-ellipsis">
                        <?=$post->title?>
                    </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>