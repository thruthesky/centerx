<div>
    <?php
    if ( loggedIn() ) echo login()->name . '님, 어서오세요';
    ?>
</div>
<div class="box d-flex flex-column">
    <?php include widget('post-latest/post-latest-default') ?>
</div>


