
<section class="p-3">

    <h1>만남사이트</h1>

    <?php if(loggedIn()) { ?>
    어서오세요, <?=login()->email?>님
    <?php } else { ?>
    로그인을 먼저 해주세요.
    <?php }  ?>


</section>