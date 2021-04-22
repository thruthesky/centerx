<?php
/**
 * @file in-app-purchase.class.php
 */
use ReceiptValidator\iTunes\Validator as iTunesValidator;
/**
 * Class InAppPurchase
 *
 * @property-read int $idx
 * @property-read int $userIdx
 * @property-read string $status
 * @property-read string $platform
 * @property-read string $productID
 * @property-read string $purchaseID
 * @property-read string $price
 * @property-read string $title
 * @property-read string $description
 * @property-read string $applicationUsername
 * @property-read int $transactionDate
 * @property-read string $productIdentifier
 * @property-read string $quantity
 * @property-read string $transactionIdentifier
 * @property-read int $transactionTimeStamp
 * @property-read string $localVerificationData
 * @property-read string $serverVerificationData
 * @property-read string $localVerificationData_packageName
 * @property-read int $createdAt
 * @property-read int $updatedAt
 */
class InAppPurchase extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(IN_APP_PURCHASE, $idx);
    }

    /**
     * @param int $idx
     * @return InAppPurchase
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        return $this;
    }


    /**
     * @param array $in
     * @return InAppPurchase
     */
    public function create( array $in ): self {

        $in[USER_IDX] = login()->idx;

        return parent::create($in);
    }




    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return InAppPurchase
     */
    public function update(array $in): self {
        return parent::update($in);
    }

    /**
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        else return $this->getData();
    }

    public function verifyPurchase($in): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( !isset($in['platform'] ) ) return $this->error( e()->empty_platform);
        if ( $in['platform'] != 'android' && $in['platform'] != 'ios') return $this->error(e()->wrong_platform);
        if ( !isset($in['productID'] ) ) return $this->error( e()->empty_product_id);
        if ( !isset($in['purchaseID'] ) ) return $this->error( e()->empty_purchase_id);
        if ( !isset($in['price'] ) ) return $this->error( e()->empty_product_price);
        if ( !isset($in['title'] ) ) return $this->error( e()->empty_product_title);
        if ( !isset($in['description'] ) ) return $this->error( e()->empty_product_description);
        if ( !isset($in['transactionDate'] ) ) return $this->error( e()->empty_transaction_date);
        if ( !isset($in['localVerificationData'] ) ) {
            return $this->error( e()->empty_local_verification_data);
        }
        if ( !isset($in['serverVerificationData'] ) ) return $this->error( e()->empty_server_verification_data);

        if ( $in['platform'] == 'ios' ) {
            if (!isset($in['productIdentifier'])) return $this->error( e()->empty_product_identifier);
            if (!isset($in['quantity'])) return $this->error( e()->empty_quantity);
            if (!isset($in['transactionIdentifier'])) return $this->error( e()->empty_transaction_identifier);
            if (!isset($in['transactionTimeStamp'])) return $this->error( e()->empty_transaction_timestamp);
        }

        debug_log("verifyPurchase", $in);

        if ( $in['platform'] == 'ios' ) { // iOS
            $res = $this->verifyIOSPurchase($in);
            $pointToCredit = IOS_POINT_PURCHASE_AMOUNT[ $in['productID'] ];
        } else { // Android
            $in["localVerificationData_packageName"] = ANDROID_APP_ID;
            $res = $this->verifyAndroidPurchase($in);
            $pointToCredit = ANDROID_POINT_PURCHASE_AMOUNT[ $in['productID'] ];
        }

        if ( isError($res) ) return $this->error( $res );

        debug_log("verifyPurchase success: ", $res);

        $in['status'] = SUCCESS;
        $this->create($in);
        if ( $this->hasError ) return $this->error($this->getError());



        point()->purchase( $pointToCredit );



        return $this;
    }


    public function recordFailure($in): self
    {
        $in['status'] = FAILURE;
        return $this->_record($in);
    }

    public function recordPending($in): self
    {
        $in['status'] = PENDING;
        return $this->_record($in);
    }

    private function _record($in): self
    {
        if ( notLoggedIn() ) return $this->error( e()->not_logged_in);
        if ( !isset($in['platform']) || empty(($in['platform'])) ) return $this->error( e()->empty_platform);
        if ( !isset($in['productID'] ) || empty(($in['productID'])) ) return $this->error( e()->empty_product_id);
        if ( !isset($in['purchaseID']) || empty(($in['purchaseID'])) ) $in['purchaseID'] = '';

        if ( !isset($in['applicationUsername']) || empty(($in['applicationUsername'])) ) $in['applicationUsername'] = '';

        if ( !isset($in['price']) || empty(($in['price'])) ) $in['price'] = '';
        if ( !isset($in['title']) || empty(($in['title'])) ) $in['title'] = '';
        if ( !isset($in['description']) || empty(($in['description'])) ) $in['description'] = '';
        if ( !isset($in['transactionDate']) || empty($in['transactionDate']) ) $in['transactionDate'] = '';


        if ( !isset($in['transactionIdentifier']) || empty(($in['transactionIdentifier'])) ) $in['transactionIdentifier'] = '';
        if ( !isset($in['transactionTimeStamp']) || empty(($in['transactionTimeStamp'])) ) $in['transactionTimeStamp'] = '';

        $in['localVerificationData'] = '';
        $in['serverVerificationData'] = '';
        debug_log("record{$in['status']}()", $in);
        return $this->create($in);
    }

    /**
     * @param array $in
     * @return array|string
     */
    public function myPurchase(array $in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;

        $myIdx = login()->idx;
        $rows = $this->search(select: "*", where: "userIdx='$myIdx' AND status='success'", limit: 1000);

        // TODO add more information or summary
//        $rets = [];
//        foreach ($rows as $row) {
//            $rets['total'] = $row
//        }
//        d($rows);
        return $rows;
    }




    /**
     * @see see the note on `savePurchaseHistory` for the input properties.
     * @param $in
     * @return array|string
     * @throws \Google\Exception
     */
    private function verifyAndroidPurchase($in) {


        $googleClient = new \Google_Client();
        $googleClient->setScopes([\Google_Service_AndroidPublisher::ANDROIDPUBLISHER]);
        $googleClient->setApplicationName('Your_Purchase_Validator_Name');
        $googleClient->setAuthConfig(GCP_SERVICE_ACCOUNT_KEY_JSON_FILE_PATH);

        $googleAndroidPublisher = new \Google_Service_AndroidPublisher($googleClient);
        $validator = new \ReceiptValidator\GooglePlay\Validator($googleAndroidPublisher);


        try {
            $response = $validator->setPackageName($in['localVerificationData_packageName'])
                ->setProductId($in['productID'])
                ->setPurchaseToken($in['serverVerificationData'])
                ->validatePurchase();
            debug_log('response->developerPayload', $response->getDeveloperPayload());

//            print("\n\nresult: ");
//            echo "\nresponse->getAcknowledgementState()"; print_r($response->getAcknowledgementState());
//            echo "\nresponse->getConsumptionState()"; print_r($response->getConsumptionState());
//            echo "\nresponse->getPurchaseState()"; print_r($response->getPurchaseState());
//            echo "\nresponse->getRawResponse()"; print_r($response->getRawResponse());
//
//            print_r("success?");
//            print_r($response);

//        $history = $this->savePurchaseHistory($in);
//        $jewelry = $this->generatePurchasedJewelry($in['productID'], $history['ID']);

            return [
                'productId' => $in['productID'],
                'transactionId' => $in['purchaseID'],  /// if the response has transactionID update this variable
//            'history' => $history,
//            'jewelry' => $jewelry
            ];
        } catch (\Exception $e){
            $msg = $e->getMessage();

            return e()->receipt_invalid . ':' . $msg;
//            var_dump($e->getMessage());
            // example message: Error calling GET ....: (404) Product not found for this application.
        }
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     *
     *
    Array
    (
    [original_purchase_date_pst] => 2012-04-30 08:05:55 America/Los_Angeles
    [original_transaction_id] => 1000000046178817
    [original_purchase_date_ms] => 1335798355868
    [transaction_id] => 1000000046178817
    [quantity] => 1
    [product_id] => com.mindmobapp.download
    [bvrs] => 20120427
    [purchase_date_ms] => 1335798355868
    [purchase_date] => 2012-04-30 15:05:55 Etc/GMT
    [original_purchase_date] => 2012-04-30 15:05:55 Etc/GMT
    [purchase_date_pst] => 2012-04-30 08:05:55 America/Los_Angeles
    [bid] => com.mindmobapp.MindMob
    [item_id] => 521129812
    )
    Receipt data = 1
    getProductId: com.mindmobapp.download
    getTransactionId: 1000000046178817
    getPurchaseDate: 2012-04-30T15:05:56+00:00
     */
    private function verifyIOSPurchase($in) {


        $validator = new iTunesValidator(iTunesValidator::ENDPOINT_PRODUCTION); // Or iTunesValidator::ENDPOINT_SANDBOX if sandbox testing


//        $receiptBase64Data = 'ewoJInNpZ25hdHVyZSIgPSAiQXBNVUJDODZBbHpOaWtWNVl0clpBTWlKUWJLOEVkZVhrNjNrV0JBWHpsQzhkWEd1anE0N1puSVlLb0ZFMW9OL0ZTOGNYbEZmcDlZWHQ5aU1CZEwyNTBsUlJtaU5HYnloaXRyeVlWQVFvcmkzMlc5YVIwVDhML2FZVkJkZlcrT3kvUXlQWkVtb05LeGhudDJXTlNVRG9VaFo4Wis0cFA3MHBlNWtVUWxiZElWaEFBQURWekNDQTFNd2dnSTdvQU1DQVFJQ0NHVVVrVTNaV0FTMU1BMEdDU3FHU0liM0RRRUJCUVVBTUg4eEN6QUpCZ05WQkFZVEFsVlRNUk13RVFZRFZRUUtEQXBCY0hCc1pTQkpibU11TVNZd0pBWURWUVFMREIxQmNIQnNaU0JEWlhKMGFXWnBZMkYwYVc5dUlFRjFkR2h2Y21sMGVURXpNREVHQTFVRUF3d3FRWEJ3YkdVZ2FWUjFibVZ6SUZOMGIzSmxJRU5sY25ScFptbGpZWFJwYjI0Z1FYVjBhRzl5YVhSNU1CNFhEVEE1TURZeE5USXlNRFUxTmxvWERURTBNRFl4TkRJeU1EVTFObG93WkRFak1DRUdBMVVFQXd3YVVIVnlZMmhoYzJWU1pXTmxhWEIwUTJWeWRHbG1hV05oZEdVeEd6QVpCZ05WQkFzTUVrRndjR3hsSUdsVWRXNWxjeUJUZEc5eVpURVRNQkVHQTFVRUNnd0tRWEJ3YkdVZ1NXNWpMakVMTUFrR0ExVUVCaE1DVlZNd2daOHdEUVlKS29aSWh2Y05BUUVCQlFBRGdZMEFNSUdKQW9HQkFNclJqRjJjdDRJclNkaVRDaGFJMGc4cHd2L2NtSHM4cC9Sd1YvcnQvOTFYS1ZoTmw0WElCaW1LalFRTmZnSHNEczZ5anUrK0RyS0pFN3VLc3BoTWRkS1lmRkU1ckdYc0FkQkVqQndSSXhleFRldngzSExFRkdBdDFtb0t4NTA5ZGh4dGlJZERnSnYyWWFWczQ5QjB1SnZOZHk2U01xTk5MSHNETHpEUzlvWkhBZ01CQUFHamNqQndNQXdHQTFVZEV3RUIvd1FDTUFBd0h3WURWUjBqQkJnd0ZvQVVOaDNvNHAyQzBnRVl0VEpyRHRkREM1RllRem93RGdZRFZSMFBBUUgvQkFRREFnZUFNQjBHQTFVZERnUVdCQlNwZzRQeUdVakZQaEpYQ0JUTXphTittVjhrOVRBUUJnb3Foa2lHOTJOa0JnVUJCQUlGQURBTkJna3Foa2lHOXcwQkFRVUZBQU9DQVFFQUVhU2JQanRtTjRDL0lCM1FFcEszMlJ4YWNDRFhkVlhBZVZSZVM1RmFaeGMrdDg4cFFQOTNCaUF4dmRXLzNlVFNNR1k1RmJlQVlMM2V0cVA1Z204d3JGb2pYMGlreVZSU3RRKy9BUTBLRWp0cUIwN2tMczlRVWU4Y3pSOFVHZmRNMUV1bVYvVWd2RGQ0TndOWXhMUU1nNFdUUWZna1FRVnk4R1had1ZIZ2JFL1VDNlk3MDUzcEdYQms1MU5QTTN3b3hoZDNnU1JMdlhqK2xvSHNTdGNURXFlOXBCRHBtRzUrc2s0dHcrR0szR01lRU41LytlMVFUOW5wL0tsMW5qK2FCdzdDMHhzeTBiRm5hQWQxY1NTNnhkb3J5L0NVdk02Z3RLc21uT09kcVRlc2JwMGJzOHNuNldxczBDOWRnY3hSSHVPTVoydG04bnBMVW03YXJnT1N6UT09IjsKCSJwdXJjaGFzZS1pbmZvIiA9ICJld29KSW05eWFXZHBibUZzTFhCMWNtTm9ZWE5sTFdSaGRHVXRjSE4wSWlBOUlDSXlNREV5TFRBMExUTXdJREE0T2pBMU9qVTFJRUZ0WlhKcFkyRXZURzl6WDBGdVoyVnNaWE1pT3dvSkltOXlhV2RwYm1Gc0xYUnlZVzV6WVdOMGFXOXVMV2xrSWlBOUlDSXhNREF3TURBd01EUTJNVGM0T0RFM0lqc0tDU0ppZG5KeklpQTlJQ0l5TURFeU1EUXlOeUk3Q2draWRISmhibk5oWTNScGIyNHRhV1FpSUQwZ0lqRXdNREF3TURBd05EWXhOemc0TVRjaU93b0pJbkYxWVc1MGFYUjVJaUE5SUNJeElqc0tDU0p2Y21sbmFXNWhiQzF3ZFhKamFHRnpaUzFrWVhSbExXMXpJaUE5SUNJeE16TTFOems0TXpVMU9EWTRJanNLQ1NKd2NtOWtkV04wTFdsa0lpQTlJQ0pqYjIwdWJXbHVaRzF2WW1Gd2NDNWtiM2R1Ykc5aFpDSTdDZ2tpYVhSbGJTMXBaQ0lnUFNBaU5USXhNVEk1T0RFeUlqc0tDU0ppYVdRaUlEMGdJbU52YlM1dGFXNWtiVzlpWVhCd0xrMXBibVJOYjJJaU93b0pJbkIxY21Ob1lYTmxMV1JoZEdVdGJYTWlJRDBnSWpFek16VTNPVGd6TlRVNE5qZ2lPd29KSW5CMWNtTm9ZWE5sTFdSaGRHVWlJRDBnSWpJd01USXRNRFF0TXpBZ01UVTZNRFU2TlRVZ1JYUmpMMGROVkNJN0Nna2ljSFZ5WTJoaGMyVXRaR0YwWlMxd2MzUWlJRDBnSWpJd01USXRNRFF0TXpBZ01EZzZNRFU2TlRVZ1FXMWxjbWxqWVM5TWIzTmZRVzVuWld4bGN5STdDZ2tpYjNKcFoybHVZV3d0Y0hWeVkyaGhjMlV0WkdGMFpTSWdQU0FpTWpBeE1pMHdOQzB6TUNBeE5Ub3dOVG8xTlNCRmRHTXZSMDFVSWpzS2ZRPT0iOwoJImVudmlyb25tZW50IiA9ICJTYW5kYm94IjsKCSJwb2QiID0gIjEwMCI7Cgkic2lnbmluZy1zdGF0dXMiID0gIjAiOwp9';

//        $receiptBase64Data = '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';
        $receiptBase64Data = $in['serverVerificationData'];
        try {
            $response = $validator->setReceiptData($receiptBase64Data)->validate();

//            print_r($response);

            // $sharedSecret = '1234...'; // Generated in iTunes Connect's In-App Purchase menu
            // $response = $validator->setSharedSecret($sharedSecret)->setReceiptData($receiptBase64Data)->validate(); // use setSharedSecret() if for recurring subscriptions
        } catch (Exception $e) {
            $errmsg = 'got error = ' . $e->getMessage() . PHP_EOL;
            debug_log($errmsg);
            return e()->receipt_invalid . ':' . $e->getMessage();
        }

        if ($response->isValid()) {
            $json = json_encode($response->getReceipt());
            debug_log("ios purchase: response->isValid()", $json);
            foreach ($response->getPurchases() as $purchase) {
                $productId = $purchase->getProductId();
                $transactionId = $purchase->getTransactionId();
            }
            return [
                'productId' => $productId ?? '',
                'transactionId' => $transactionId ?? '',
            ];
        } else {
            return e()->receipt_invalid . ':' . $response->getResultCode();
        }
    }




}


/**
 * @param int $idx
 * @return InAppPurchase
 *
 *
 */
function inAppPurchase(int $idx = 0): InAppPurchase
{
    return new inAppPurchase($idx);
}
