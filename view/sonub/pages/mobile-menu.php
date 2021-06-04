<section class="mobile-menu-page">

    <div class="inner p-3">

        <div class="container d-none" :class="{'d-block': loggedIn }">
            <div class="row mt-3">
                <div class="col-5 pr-0">
                    <?php include widget('user/profile-photo-update'); ?>
                </div>
                <div class="col-7 pl-0 d-flex align-items-center">
                    <div class="col text-center">
                        <div>글</div>
                        <div class="fs-lg"><?=post()->countMine()?></div>
                    </div>
                    <div class="col text-center">
                        <div>코멘트</div>
                        <div class="fs-lg"><?=comment()->countMine()?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if ( loggedIn() ) { ?>
                <div class="col-5 d-flex justify-content-center p-2 fs-sm">
                    <?=login()->nicknameOrName?> (<?=ln(login()->gender, '?')?>/<?=login()->age?>세)
                </div>
                <?php } ?>
                <div class="col-7 d-flex justify-content-center fs-sm">

                </div>
            </div>
        </div>


        <section class="mt-3">
            <div class="fs-sm"><?=ln('setting')?></div>
            <hr class="my-2">
            <section class="menus p-3 border-radius-md bg-light">
                <?php if ( loggedIn() ) { ?>
                    <a class="px-1 py-2" href="/?user.profile"><?=ln('profile')?></a>
                    <a class="px-1 py-2" href="/?user.logout.submit"><?=ln('logout')?></a>
                <?php } else { ?>
                    <a class="px-1 py-2" href="/?user.login"><?=ln('login')?></a>
                    <a class="px-1 py-2" href="/?p=user.register"><?=ln('register')?></a>
                <?php } ?>
            </section>
        </section>

        <section class="mt-3">
            <div class="fs-sm"><?=ln('community')?></div>
            <hr class="my-2">
            <section class="menus p-3 border-radius-md bg-light">
                <?php
                foreach( cafe()->cafeMenus['community'] as $categoryId => $m ) {
                    ?>
                    <a href="/?p=forum.post.list&categoryId=<?=$categoryId?>" class="py-2 px-1"><?=$m['title']?></a>
                <?php } ?>
            </section>
        </section>


        <section class="mt-2">
            <div class="fs-sm"><?=ln('business')?></div>
            <hr class="my-2">
            <section class="menus p-3 border-radius-md bg-light">
                <?php
                foreach( cafe()->cafeMenus['business'] as $categoryId => $m ) {
                    ?>
                    <a href="/?p=forum.post.list&categoryId=<?=$categoryId?>" class="py-2 px-1"><?=$m['title']?></a>
                <?php } ?>
            </section>
        </section>
    </div>

</section>