<?php

class ShoppingMallOrder extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(SHOPPING_MALL_ORDERS, $idx);
    }
}


/**
 * @param int $idx
 * @return ShoppingMallOrder
 */
function shoppingMallOrder(int $idx=0): ShoppingMallOrder
{
    return new ShoppingMallOrder($idx);
}



