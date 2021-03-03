
<style>
    .hint { font-size: .8rem; color: #888888; }
</style>
<section id="app">

    <h1>상품 등록</h1>
    <form method="post" action="/">

        <input type="hidden" name="p" value="<?=in('p')?>">
        <input type="hidden" name="w" value="<?=in('w')?>">
        <input type="hidden" name="cw" value="<?=in('cw')?>">
        <input type="hidden" name="idx" value="<?=$post[IDX] ?? '0'?>">
        <input type="hidden" name="mode" value="submit">

        <div class="form-group mb-3">
            <label for="post_title">제목</label>
            <input type="text" class="form-control" name="title" value="<?=$post[TITLE] ?? ''?>">
        </div>
    </form>
</section>
