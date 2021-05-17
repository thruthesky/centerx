
<div class="container-xl">
    <div class="d-flex justify-content-between l-content fs-sm bg-light border-radius-bottom-sm">
        <div class="d-flex">
            <a class="p-2 pl-3" href="/">홈</a>
            <?php if ( loggedIn() ) { ?>
                <a class="p-2" href="/?user.profile">회원 정보</a>
                <a class="p-2" href="/?user.logout.submit">로그아웃</a>
            <?php } else { ?>
                <a class="p-2" href="/?user.login">로그인</a>
                <a class="p-2" href="/?p=user.login&mode=register">가입</a>
            <?php } ?>
            <a class="p-2" href="/?p=forum.post.list&categoryId=discussion">자유게시판</a>
            <a class="p-2" href="/?p=forum.post.list&categoryId=qna">질문게시판</a>
        </div>
        <div class="d-flex">
            <form class="m-0 p-0" action="/">
                <input type="hidden" name="p" value="user.language.submit">
                <label class="m-0 p-2">
                    <select name="language" onchange="submit()">
                        <option value="">언어선택</option>
                        <option value="ko">한국어</option>
                        <option value="en">English</option>
                    </select>
                </label>
            </form>
            <div class="p-2">(<?=cafe()->countryCode?>)</div>
            <a class="p-2" href="/?p=forum.post.list&categoryId=discussion">광고문의</a>
            <a class="p-2 pr-3" href="/?p=forum.post.list&categoryId=qna">운영자문의</a>
        </div>
    </div>

    <div class="d-flex justify-content-between l-content fs-sm">
        <div>
            <div class="" style="margin-top: 44px;">
                <img class="banner-255x100 border-radius-md" src="/themes/sonub/tmp/banner.jpg">
            </div>
        </div>
        <div class="mt-3 mx-3 mx-lg-5 px-xl-5 w-100">
            <a class="d-flex justify-content-center align-items-center mb-2" href="/">
                <img class="h-48px" src="/themes/sonub/img/philov-logo.png">
                <div class="ml-3 fs-xl"><?=cafe()->title?></div>
            </a>
            <form action="/">
                <input type="hidden" name="p" value="forum.post.list">
                <div class="position-relative">
                    <input class="focus-none pl-3 pr-5 py-1 fs-lg w-100 border-radius-md border-grey" name="searchKey">
                    <div class="position-absolute top right mr-1 fs-lg dark">
                        <div style="padding: 0.6rem;"><i class="fa fa-search"></i></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-none d-lg-block">
            <div style="margin-top: 44px;">
                <img class="banner-255x100 border-radius-md" src="/themes/sonub/tmp/banner2.jpg">
            </div>
        </div>
    </div>

</div>

<nav class="mainmenu-desktop mt-1 mb-3">

    <div class="container-xl d-flex justify-content-between fs-md">
        <div class="d-flex justify-content-around" style="min-width: 300px; max-width: 300px; height: 40px; overflow:hidden; background-color: rgba(248,248,248,0.78);">

            <?php if ( cafe()->isMainCafe() ) { ?>
                <div class="py-2">카페를 개설하세요.</div>
            <?php } else if ( cafe()->exists == false ) { ?>
                <div class="py-2">존재하지 않는 카페입니다.</div>
            <?php } else { ?>
                <?php if ( cafe()->subcategories ) { ?>
                    <?php foreach( array_slice(cafe()->subcategories, 0, 5) as $catName ) { ?>
                        <a class="py-2" href="/?forum.post.list&categoryId=<?=cafe()->id?>&subcategory=<?=$catName?>"><?=$catName?></a>
                    <?php } ?>
                <?php } else { ?>
                    <?php if ( cafe()->isMine() ) { ?>
                        <a class="py-2" href="/?cafe.admin">카테고리 추가하기</a>
                    <?php } else { ?>
                        <?=cafe()->name()?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>


        </div>
        <?php
        foreach( cafe()->cafeMainMenus as $categoryId => $m ) {
            ?>
            <a class="py-2" href="/?p=forum.post.list&categoryId=<?=$categoryId?>"><?=$m['title']?></a>
        <?php } ?>
    </div>
</nav>


<style>
    .mainmenu-desktop {
        border-top: 1px solid #efefef; border-bottom: 1px solid #d0d0d0; box-shadow: 1px 1px 1px 1px #f8f8f8;
    }
</style>