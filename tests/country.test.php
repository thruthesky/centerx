<?php

isTrue(get_class(country()) == 'CountryTaxonomy', 'CountryTaxonomy');

$country = country();
$countries = $country->search(select: "*", limit: 1000);
$count = count($countries) -1;

$c = rand(0,$count);
isTrue(country($countries[$c]["2digitCode"])->idx == $countries[$c][IDX], "read via 2digitcode");
isTrue(country($countries[$c]["3digitCode"])->idx == $countries[$c][IDX], "read via 3digitcode");

$c = rand(0, $count);
$c3 = country($countries[$c]["3digitCode"], true);
isTrue($c3->hasError, "should be error, currency code is set to true");
isTrue($c3->getError() == e()->entity_not_found, "should not exist since 3digit code is different from currencycode");


/**
 * Note* currencyCode exist on many countries
 */
//$c = rand(0, $count);
//if(!empty($countries[$c]["currencyCode"])) {
//    d($countries[$c]["currencyCode"], "currencyCode");
//    $cc = country($countries[$c]["currencyCode"], true);
//    isTrue($cc->hasError == false, "get via currency code");
//    d($cc->idx . " == " . $countries[$c][IDX]);
//    isTrue($cc->idx == $countries[$c][IDX], "read via currencyCode");
//    isTrue($cc->currencyCode == $countries[$c]['currencyCode'], "check currencyCode");
//}

$c = rand(0, $count);
isTrue(country($countries[$c][IDX])->idx == $countries[$c][IDX], "read via idx");