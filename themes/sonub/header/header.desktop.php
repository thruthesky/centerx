
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


    <div class="container-xl mt-3">
        <div class="row">
            <div class="ad-top col-4 col-lg-3 pl-0 d-flex align-items-center">
                <?php include widget('advertisement/banner', ['type' => AD_TOP, 'place' => 'L']) ?>
            </div>
            <div class="col-8 col-lg-6">
                <a class="d-block fs-lg text-center mb-1" href="/">
                    <?php
                    // 로고 이미지가 있으면, 로고 이미지 표시
                    // 아니면, 제목 표시
                    // 아니면, id 표시
                    $titleImage = cafe()->titleImage();
                    if ( $titleImage->ok ) echo "<img class='w-100' src='{$titleImage->url}'>";
                    else if ( cafe()->title ) echo cafe()->title;
                    else if ( cafe()->id ) echo cafe()->id;
                    else echo cafe()->rootCafeName();
                    ?>
                </a>
                <?php include theme()->file('parts/search-box') ?>
            </div>
            <div class="ad-top d-none d-lg-flex col-3 pr-0 align-items-center">
                <?php include widget('advertisement/banner', ['type' => AD_TOP, 'place' => 'R']) ?>
            </div>
        </div>
    </div>

</div>

<nav class="mainmenu-desktop mt-1 mb-3">

    <div class="container-xl d-flex justify-content-between fs-md">
        <div class="left d-flex justify-content-around">

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
        foreach( cafe()->mainMenus as $categoryId => $m ) {
            ?>
            <a class="a py-2" href="/?p=forum.post.list&categoryId=<?=$categoryId?>"><?=$m['title']?></a>
        <?php } ?>
    </div>
</nav>


<style>
    .mainmenu-desktop {
        border-top: 1px solid #efefef;
        border-bottom: 1px solid #d0d0d0;
        box-shadow: 1px 1px 1px 1px #f8f8f8;
        height: 2.5em;
        overflow: hidden;
    }
    .mainmenu-desktop .left {
        min-width: 300px;
        max-width: 300px;
        height: 40px;
        overflow:hidden;
        background-color: rgba(248,248,248,0.78);
    }
    .mainmenu-desktop .a {
        min-width: 30px;
    }
</style>