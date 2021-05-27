
<div class="d-flex justify-content-center mt-3">
    <div class="position-relative">
        <div class="circle bg-light">
            <i class="fas fa-user-circle fs-xxl"></i>
        </div>
        <i class="fas fa-camera fs-lg position-absolute bottom p-1"></i>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div>회원이름 (남/29세)</div>
</div>


<div class="row mt-5">
    <div class="col text-center">
        글 수
        <div class="fs-lg">158</div>
    </div>
    <div class="col text-center">
        코멘트 수
        <div class="fs-lg">3,273</div>
    </div>
    <div class="col text-center">
        추천 수
        <div class="fs-lg">3,018</div>
    </div>
</div>


<?php if ( loggedIn() ) { ?>
    <a class="p-2" href="/?user.profile">회원 정보</a>
    <a class="p-2" href="/?user.logout.submit">로그아웃</a>
<?php } else { ?>
    <a class="p-2" href="/?user.login">로그인</a>
    <a class="p-2" href="/?p=user.register">가입</a>
<?php } ?>


<div class="d-flex flex-wrap justify-content-around">
    <?php
        foreach( cafe()->cafeMainMenus as $categoryId => $m ) {
    ?>
            <a href="/?p=forum.post.list&categoryId=<?=$categoryId?>" class="circle m-2"><?=$m['title']?></a>
    <?php } ?>
</div>




