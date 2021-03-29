<?php

class InAppPurchaseRoute {


    public function verifyPurchase($in) {

        $iap = inAppPurchase();

        if ( !isset($in['platform'] ) ) return e()->empty_platform;// ERROR_EMPTY_PLATFORM;
//        if ( !isset($in['productID'] ) ) return ERROR_EMPTY_PRODUCT_ID;
//        if ( !isset($in['purchaseID'] ) ) return ERROR_EMPTY_PURCHASE_ID;
//        if ( !isset($in['price'] ) ) return ERROR_EMPTY_PRODUCT_PRICE;
//        if ( !isset($in['title'] ) ) return ERROR_EMPTY_PRODUCT_TITLE;
//        if ( !isset($in['description'] ) ) return ERROR_EMPTY_PRODUCT_DESCRIPTION;
//        if ( !isset($in['transactionDate'] ) ) return ERROR_EMPTY_TRANSACTION_DATE;
//        if ( !isset($in['productIdentifier'] ) ) return ERROR_EMPTY_PRODUCT_IDENTIFIER;
//        if ( !isset($in['quantity'] ) ) return ERROR_EMPTY_QUANTITY;
//        if ( !isset($in['transactionIdentifier'] ) ) return ERROR_EMPTY_TRANSACTION_IDENTIFIER;
//        if ( !isset($in['transactionTimeStamp'] ) ) return ERROR_EMPTY_TRANSACTION_TIMESTAMP;
//        if ( !isset($in['localVerificationData'] ) ) return ERROR_EMPTY_LOCAL_VERIFICATION_DATA;
//        if ( !isset($in['serverVerificationData'] ) ) return ERROR_EMPTY_SERVER_VERIFICATION_DATA;
//
//
//        if ( $in['platform'] == 'android' ) {
//            if ( !isset($in['localVerificationData_packageName']) ) return ERROR_EMPTY_PACKAGE_NAME;
//        }
//
//
//        if ( $in['platform'] == 'ios' ) {
//            return $this->credit->verifyIOSPurchase($in);
//        } else if ( $in['platform'] == 'android' ) {
//            return $this->credit->verifyAndroidPurchase($in);
//        } else {
//            return ERROR_WRONG_PLATFORM;
//        }

        $iap->create($in);

        return $iap->response();
    }
}