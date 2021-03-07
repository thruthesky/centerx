<?php

?>
<section class="box">
    <h1>카페 개설하기</h1>
    <hr>
    <form class="mt-3 mb-0">
        <input type="hidden" name="p" value="cafe.create.submit">
        <label class="fs-sm" for="countryCode">교민 카페 운영 국가 선택</label>
        <select class="form-select" id="countryCode" name="countryCode" aria-label="Country selection box">
            <option selected>국가를 선택해주세요.</option>
            <?php

            foreach( country_code() as $co ) {
                ?>
                <option value="<?=$co['2digitCode']?>"><?=$co['CountryNameKR']?></option>
            <?php } ?>
        </select>

        <div class="mt-2">https://<input class="w-80px underline focus-none">.<?=get_root_domain()?></div>
        <div class="mt-2 d-flex justify-content-end">
            <button class="btn btn-sm btn-link">카페 생성</button>
        </div>
    </form>
</section>