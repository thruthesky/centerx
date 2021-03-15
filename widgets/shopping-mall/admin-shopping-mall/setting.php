<?php
if ( modeSubmit() ) {
    config()->set('deliveryFeeFreeLimit', in('deliveryFeeFreeLimit'));
    config()->set('deliveryFeePrice', in('deliveryFeePrice'));
}
?>
<style>
    .hint { font-size: .8rem; color: #888888; }
</style>
<section id="app">


    <h1>쇼핑몰 설정</h1>
    <form method="post" action="/">

        <?=hiddens(in: ['p', 'w', 'cw'], mode: 'submit') ?>


        <div class="mb-3">
            <label class="form-label">배송비 무료 결제 금액 하한가</label>
            <input type="number" class="form-control" name="deliveryFeeFreeLimit" v-model="deliveryFeeFreeLimit">
            <div id="emailHelp" class="form-text">총 결제 금액이 {{ deliveryFeeFreeLimit.toLocaleString() }}원 이상이면 무료입니다.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">배송비</label>
            <input type="number" name="deliveryFeePrice" class="form-control" v-model="deliveryFeePrice">
            <div id="emailHelp" class="form-text">총 결제 금액이 {{ deliveryFeeFreeLimit.toLocaleString() }}원 미만인 경우, 배송비가 {{ deliveryFeePrice.toLocaleString() }}원입니다.</div>
        </div>
        <button type="submit" class="btn btn-primary">저장하기</button>

    </form>
</section>

<script src="<?=ROOT_URL?>/etc/js/vue.3.0.7.global.prod.min.js"></script>

<script>
    const attr = {
        data() {
            return {
                deliveryFeeFreeLimit: <?=config('deliveryFeeFreeLimit', DEFAULT_DELIVERY_FEE_FREE_LIMIT)?>,
                deliveryFeePrice: <?=config('deliveryFeePrice', DEFAULT_DELIVERY_FEE_PRICE)?>,
            };
        },
        created() {
            console.log('setting created');
        }
    };
    const app = Vue.createApp(attr).mount('#app');
</script>


