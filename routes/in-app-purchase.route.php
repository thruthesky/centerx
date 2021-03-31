<?php

class InAppPurchaseRoute {


    public function verifyPurchase($in): array|string
    {
        return inAppPurchase()->verifyPurchase($in)->response();
    }

    public function recordFailure($in): array|string
    {
        return inAppPurchase()->recordFailure($in)->response();

    }
    public function recordPending($in): array|string
    {
        return inAppPurchase()->recordPending($in)->response();
    }
    public function myPurchase($in): array|string
    {
        return inAppPurchase()->myPurchase($in)->response();
    }



}