
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
            <div class="ml-3 fs-xl">필러브</div>
        </a>
        <form>
            <div class="position-relative">
                <input class="focus-none pl-3 pr-5 py-1 fs-lg w-100 border-radius-md border-grey">
                <div class="position-absolute top right mr-1 p-2 fs-lg dark">
                    <i class="fa fa-search"></i>
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
        <a class="py-2" href="/?p=forum.post.list&categoryId=discussion">자유토론</a>
        <a class="py-2" href="/?p=forum.post.list&categoryId=qna">질문답변</a>
        <a class="py-2" href="/?p=forum.post.list&categoryId=market">회원장터</a>
        <a class="py-2" href="#">자유토론</a>
        <a class="py-2" href="#">질문답변</a>
        <a class="py-2" href="#">회원장터</a>
        <a class="py-2" href="#">자유토론</a>
        <a class="py-2" href="#">질문답변</a>
        <a class="py-2" href="#">회원장터</a>
        <a class="py-2" href="#">자유토론</a>
        <a class="py-2" href="#">질문답변</a>
        <a class="py-2" href="#">회원장터</a>
    </div>
</nav>


<style>
    .mainmenu-desktop {
        border-top: 1px solid #efefef; border-bottom: 1px solid #d0d0d0; box-shadow: 1px 1px 1px 1px #f8f8f8;
    }
</style>