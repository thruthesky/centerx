<div class="d-flex justify-content-between bg-blue white">
    <div class="d-flex">
        <a class="p-2" href="/"><?=cafe()->name()?></a>
        <a class="p-2" href="/?p=forum.post.list&categoryId=discussion">자유게시판</a>
        <a class="p-2" href="/?p=forum.post.list&categoryId=qna">질문게시판</a>
        <a class="p-2" href="/?p=forum.post.list&categoryId=reminder">공지사항</a>
    </div>


    <div>
        <?php if (cafe()->isMainCafe()) {?><a class="p-2" href="/?cafe.create">카페개설</a><?php } ?>

        <?php if ( admin() ) { ?>
        <a href="/?p=admin.index">관</a>
        <?php } ?>
        <?php if( str_contains(theme()->pageName(), 'menu')) { ?>
            <a class="p-2 fs-lg" href="/"><i class="fas fa-times"></i></a>
        <?php } else { ?>
            <a class="p-2 fs-lg" href="/?pages.menu"><i class="fas fa-bars"></i></a>
        <?php } ?>
    </div>
</div>
