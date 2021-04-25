<div class="box mb-2 border-radius-md">
    <?php
    if ( loggedIn() ) echo login()->name . '님, 어서오세요';
    if ( admin() ) echo ' <a href="/?admin.index">[관리자]</a>';
    ?>
</div>
<div class="box d-flex flex-column children-a-ellipsis">
    <h1 class="p-1">최근 글</h1>
    <?php include widget('post-latest/post-latest-default', ['id' => 'left-latest']) ?>
</div>
<style>
    #left-latest a { display: block; padding: .25em; font-size: .9rem; }
</style>

