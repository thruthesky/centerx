<?php

class InAppPurchaseRoute {


    public function verifyPurchase($in): array|string
    {
        return inAppPurchase()->verifyPurchase($in)->response();
    }

    public function recordFailure($in): array|string
    {
        return inAppPurchase()->recordFailure($in);

    }
    public function recordPending($in): array|string
    {
        return inAppPurchase()->recordPending($in);
    }



}