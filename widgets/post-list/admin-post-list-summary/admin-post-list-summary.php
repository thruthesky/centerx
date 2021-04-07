<style>
    .fw-700 {
        font-weight: 700;
    }
    .bg-skyblue {
        background: #CAF9FF;
    }
    .color-lightblue {
        color: #00B4CB;
    }
    .hw-54x54 {
        height: 54px;
        width: 54px;
    }
    .text-overflow-ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<section id="admin-post-list-summary">
    <div class="d-flex justify-content-start py-3 px-4 fw-700">
        <div class="pr-4">
            <div class="d-flex justify-content-center align-items-center hw-54x54 rounded-circle bg-skyblue color-lightblue">Event</div>
        </div>
        <div class="py-3 overflow-hidden">
            <?php
            $category = category('qna');
            foreach( post()->search(where: "categoryIdx='{$category->idx}'") as $post ) {
                ?>
                    <div class="text-overflow-ellipsis">
                        <?=$post->title?> im asdasdthe new c im asdasdthe new c im asdasdthe new c im asdasdthe new cim asdasdthe new c im asdasdthe new c im asdasdthe new c im asdasdthe new c
                    </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>