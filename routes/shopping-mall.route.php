<?php


class ShoppingMallRoute
{
    public function options()
    {
        return [
            'deliveryFeeFreeLimit' => config('deliveryFeeFreeLimit', DEFAULT_DELIVERY_FEE_FREE_LIMIT),
            'deliveryFeePrice' => config('deliveryFeePrice', DEFAULT_DELIVERY_FEE_PRICE),
        ];
    }


    /**
     * @param $in
     * @return mixed
     */
    public function order($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in['info']) ) return e()->wrong_params;

        $data = [
            USER_IDX => login()->idx,
            'info' => $in['info'],
        ];


        $info = json_decode($data['info'], ARRAY_A);

        $point = $info['pointToUse'];


        /// 상품 주문을 할 때, 회원 포인트를 사용한다면,
        if ( $point ) {
            if ( my(POINT) < $point ) { // 포인트가 모자라면, 주문을 하지 못하도록 한다.
                return e()->lack_of_point;
            }
        }

        $record = shoppingMallOrder()->create($data);

        if ( $point ) {
            // 포인트를 차감하고 기록을 남긴다.
            $applied = point()->addUserPoint(my(IDX), -$point);
            debug_log("applied: $applied");
            point()->log(
                POINT_ITEM_ORDER,
                toUserIdx: my(IDX),
                toUserPointApply: -$point,
                taxonomy: SHOPPING_MALL_ORDERS,
                entity: $record[IDX],
            );
        }

        $record['info'] = json_decode($record['info']);
        return $record;
    }


    /**
     * @param $in
     * @return array
     * @throws Exception
     */
    public function myOrders($in) {
        $rets = [];
        foreach( shoppingMallOrder()->my(limit: 2000) as $row ) {
            $row['info'] = json_decode($row['info']);
            $rets[] = $row;
        }
        return $rets;
    }



    /**
     * @param $in
     * @return array|object|string|void|null
     */
    public function cancelOrder($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_not_set;
        $order = shoppingMallOrder($in[IDX]);
        if ( $order->exists() === false ) return e()->order_not_exists;
        if ( $order->isMine() === false ) return e()->not_your_order;
        if ( $order->value('confirmedAt') ) return e()->order_confirmed;
        itemOrderPointRestore($in[IDX]);
        $record = $order->get();
        $order->delete();
        return $record;
    }



}