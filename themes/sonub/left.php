
<div class="box mb-2 border-radius-md">
    <?php include widget('login/login')?>

    <?php
        if ( cafe()->isMine() ) {
            ?>
            <hr>
            <a href="?cafe.admin">카페 관리자</a>
    <?php
        }
    ?>
</div>


<?php //include widget('message/message-side-menu')?>

<div class="box d-flex flex-column children-a-ellipsis">
    <h1 class="p-1">최근 글</h1>
    <?php include widget('post-latest/post-latest-default', ['id' => 'left-latest', 'categoryId' => 'qna']) ?>
</div>
<style>
    #left-latest a { display: block; padding: .25em; font-size: .9rem; }
</style>



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
