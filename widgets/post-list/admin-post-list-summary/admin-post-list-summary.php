<?php
/**
 * @type admin
 */
$o = getWidgetOptions();
?>
<section data-cy="admin-post-list-summary-widget">
    <div class="d-flex justify-content-start py-3 px-4 fw-700">
        <div class="pr-4">
            <div class="d-flex justify-content-center align-items-center hw-54x54 rounded-circle bg-skyblue color-lightblue"><?= ln(['en' => 'Event', 'ko' => '이벤트']) ?></div>
        </div>
        <div class="py-3 overflow-hidden">
            <?php
            foreach( post()->search(where: "categoryIdx=?", params:[$o['categoryIdx']], limit: $o['limit'], object: true) as $post ) {
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