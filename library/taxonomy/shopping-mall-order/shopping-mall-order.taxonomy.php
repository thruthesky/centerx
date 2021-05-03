<?php

/**
 * Class ShoppingMallOrderTaxonomy
 *
 * @property-read int userIdx
 * @property-read string info
 * @property-read int confirmedAt
 *
 */
class ShoppingMallOrderTaxonomy extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(SHOPPING_MALL_ORDERS, $idx);
    }


    /**
     * 상품 주문 했을 때, 추가한 포인트를 뺀다.
     *
     * @return $this
     */
    public function pointRestore(): ShoppingMallOrderTaxonomy {
        // 현재 상품 정보
        $info = json_decode($this->info, true);
        // 현재 상품 주문자
        $userIdx = $this->userIdx;
        // 차감된 포인트
        $point = $info['pointToUse'];
        // 차감된 포인트를 증가
        point()->addUserPoint($userIdx, $point);
        // 기록
        point()->log(
            POINT_ITEM_RESTORE,
            toUserIdx: $userIdx,
            toUserPointApply: $point,
            taxonomy: SHOPPING_MALL_ORDERS,
            entity: $this->idx,
        );
        return $this;
    }


    public function confirmed(): bool {
        return $this->confirmedAt > 0;
    }

    /**
     * 구매 확정을 한다.
     *
     * 적립 포인트가 있으면, 구매 확정 시, 포인트를 적립시켜준다.
     */
    public function confirm() {
        $info = json_decode($this->info, true);
        $this->update(['confirmedAt' => time()]);
        if ( !isset($info['pointToSave']) || empty($info['pointToSave']) ) return;
        // 현재 로그인한 사용자(관리자)가 아니라, 회원의 포인트 적립.
        $userIdx = $this->userIdx;
        $applied = point()->addUserPoint($userIdx, $info['pointToSave']);
        point()->log(
            reason: POINT_ORDER_CONFIRM,
            toUserIdx: $userIdx,
            toUserPointApply: $applied,
            taxonomy: SHOPPING_MALL_ORDERS,
            entity: $this->idx,
        );
    }

}


/**
 * @param int $idx
 * @return ShoppingMallOrderTaxonomy
 */
function shoppingMallOrder(int $idx=0): ShoppingMallOrderTaxonomy
{
    return new ShoppingMallOrderTaxonomy($idx);
}



