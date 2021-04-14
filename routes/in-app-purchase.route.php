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
        $rows = inAppPurchase()->myPurchase($in);
	/// Remove local & server verification data to reduce the size of return to client.
	$rets = [];
	foreach( $rows as $row ) {
		unset($row['localVerificationData']);
		unset($row['serverVerificationData']);
		$rets[] = $row;
	}
	return $rets;
    }



}
