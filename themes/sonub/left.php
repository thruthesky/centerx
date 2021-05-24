

<div class="ad-wing">
    <?php include widget('advertisement/banner', ['type' => AD_WING] ) ?>
</div>



<div class="box d-flex flex-column children-a-ellipsis">
    <h1 class="p-1">최근 글</h1>
    <?php include widget('post-latest/post-latest-default', ['id' => 'left-latest', 'categoryId' => 'qna']) ?>
</div>



<div class="left-banner mt-2">
    <?php
    $posts = post()->latest(categoryId: 'qna', limit: 1);
    $post = empty($posts) ? null : $posts[0];
    include widget('post/photo-with-inline-text-at-bottom', ['post' => $post]);
    ?>
</div>

<div class="left-banner mt-2">
    <?php
    $posts = post()->latest(categoryId: 'qna', limit: 1);
    $post = empty($posts) ? null : $posts[0];
    include widget('post/photo-with-text-at-bottom', ['post' => $post]);
    ?>
</div>
