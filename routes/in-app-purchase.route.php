<?php

class InAppPurchaseRoute {


    public function verifyPurchase($in) {
        return inAppPurchase()->verifyPurchase($in)->response();
    }

    public function recordFailure($in)
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        $in['status'] = 'failure';
        return inAppPurchase()->create($in)->response();
    }
        public function recordPending()
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( !isset($in['platform'] ) ) return e()->empty_platform;
        if ( !isset($in['productID'] ) ) return e()->empty_product_id;
        if ( !isset($in['price'] ) ) return e()->empty_product_price;
        if ( !isset($in['title'] ) ) return e()->empty_product_title;
        if ( !isset($in['description'] ) ) return e()->empty_product_description;
        $in['status'] = 'pending';
        return inAppPurchase()->create($in)->response();
    }



}