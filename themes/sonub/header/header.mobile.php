<div class="d-flex justify-content-between bg-blue white">
    <div class="d-flex">
        <a class="p-2" href="/">홈</a>
        <a class="p-2" href="/?p=forum.post.list&categoryId=discussion">자유토론</a>
        <a class="p-2" href="/?p=forum.post.list&categoryId=qna">질문</a>
        <a class="p-2" href="/?p=forum.post.list&categoryId=reminder">공지사항</a>
    </div>
    <div class="d-flex align-items-center">
        <?php if ( admin() ) { ?>
        <a href="/?p=admin.index">관</a>
        <?php } ?>
        <div class="d-none p-2 fs-lg" :class="{'d-block': showMobileMenu}" href="/" @click="showMobileMenu=false"><i class="fas fa-times"></i></div>
        <div class="p-2 fs-lg" @click="showMobileMenu=true" v-if="showMobileMenu == false"><i class="fas fa-bars"></i></div>
    </div>
</div>


<div class="d-none m-2" :class="{ 'd-block': showMobileMenu == false }">
    <?php include theme()->file('parts/search-box') ?>
</div>


<div class="d-none" :class="{ 'd-block': showMobileMenu }">
    <?php include theme()->file('pages/mobile-menu'); ?>
</div>
