<?php

if ( modeSubmit() ) {
    config()->set(TOKEN_REGISTER, in(TOKEN_REGISTER));
    config()->set(TOKEN_RECOMMENDATION, in(TOKEN_RECOMMENDATION));
    config()->set(TOKEN_IN_APP_PURCHASE, in(TOKEN_IN_APP_PURCHASE));
}


?>

<h1>토큰 설정</h1>

<div class="hint">
    <ul>
        <li>양수 값을 지정하면 포인트가 증가</li>
        <li>음수 값을 지정하면 포인트가 차감</li>
    </ul>
</div>

<form action="?" method="post">
    <input type="hidden" name="p" value="<?=in('p')?>">
    <input type="hidden" name="w" value="<?=in('w')?>">
    <input type="hidden" name="mode" value="submit">

    <div class="box border-radius-md">
        <div class="mb-3">
            <label class="form-label"><?=ek('Registration token', '회원 가입 토큰')?></label>
            <input type="number" class="form-control" name="TOKEN_REGISTER" placeholder="0" value="<?=config(TOKEN_REGISTER, 0)?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?=ek('Login token', '친구 추천 토큰')?></label>
            <input type="number" class="form-control" name="TOKEN_RECOMMENDATION" placeholder="0" value="<?=config(TOKEN_RECOMMENDATION, 0)?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?=ek('Login token', '포인트 구매 토큰')?></label>
            <input type="number" class="form-control" name="TOKEN_IN_APP_PURCHASE" placeholder="0" value="<?=config(TOKEN_IN_APP_PURCHASE, 0)?>">
        </div>
    </div>

    <div class="box border-radius-md mt-3">
        <hr>
        <div class="hint">
            <ul>
                <li>회원 가입하면 지급 받게 되는 토큰 - 회원 가입을 하면 1회 300 토큰을 지급 ex) 300</li>
                <li>사용자 추천시 추천 받은 사람이 받게 되는 토큰 - 친구 추천을 받을 때마다 10 토큰을 지급 ex) 10</li>
                <li>인앱결제로 포인트를 구매하면 받게 되는 토큰의 비율 입력 - 포인트 결제 금액의 10%로를 토큰으로 지급 ex) 10</li>
                <li>%단위를 빼고 숫자만 입력 </li>
            </ul>
        </div>


    <div class="d-grid">
        <button class="btn btn-primary mt-3" type="submit">저장</button>
    </div>

</form>

