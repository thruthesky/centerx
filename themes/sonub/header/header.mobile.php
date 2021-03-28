<div class="d-flex justify-content-between bg-blue white">
    <a class="p-2" href="/">홈</a>

    <?php if( str_contains(theme()->pageName(), 'menu')) { ?>
        <a class="p-2 fs-lg" href="/"><i class="fas fa-times"></i></a>
    <?php } else { ?>
        <a class="p-2 fs-lg" href="/?pages.menu"><i class="fas fa-bars"></i></a>
    <?php } ?>
</div>