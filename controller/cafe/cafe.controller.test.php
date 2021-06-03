<?php


cafeCreateTest();


function cafeCreateTest() {

    $re = request("cafe.create");
    isTrue($re == e()->not_logged_in, "not logged in");

    setLoginAny();
    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId
    ]);
    isTrue($re == e()->empty_root_domain, "empty rootDomain");

    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com"
    ]);
    isTrue($re == e()->empty_country_code, "empty countryCode");

    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com",
        'countryCode' => "ABC"
    ]);
    isTrue($re == e()->malformed_country_code, "empty malformed_country_code");
    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com",
        'countryCode' => "12"
    ]);
    isTrue($re == e()->malformed_country_code, "empty malformed_country_code");


    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com",
        'countryCode' => "PH"
    ]);
    isTrue($re == e()->empty_domain, "empty domain");

    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com",
        'countryCode' => "PH",
        'domain' => "12345abcde"
    ]);
    isTrue($re == e()->domain_should_be_alphanumeric_and_start_with_letter, "invalid domain");

    $domain = "toolongString" . time();
    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com",
        'countryCode' => "PH",
        'domain' => $domain
    ]);
    isTrue($re == e()->domain_too_long, "too long domain");


    $domain = "cafeTest" . time();
    $re = request("cafe.create", [
        SESSION_ID => login()->sessionId,
        'rootDomain' => "cafeTest.com",
        'countryCode' => "PH",
        'domain' => $domain
    ]);
    isTrue($re[IDX], "cafe create success");

}


