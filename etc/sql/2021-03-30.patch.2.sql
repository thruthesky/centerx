ALTER TABLE `wc_in_app_purchase` CHANGE `transactionDate` `transactionDate` VARCHAR(255) NOT NULL DEFAULT '',
    CHANGE `quantity` `quantity` VARCHAR(255) NOT NULL DEFAULT '',
    CHANGE `transactionIdentifier` `transactionIdentifier` VARCHAR(255) NOT NULL DEFAULT '',
    CHANGE `transactionTimeStamp` `transactionTimeStamp` VARCHAR(255) NOT NULL DEFAULT '';