<?php

isTrue(get_class(country()) == 'CountryModel', 'CountryModel');

defaultCountryTest();
countryModelTest();

function defaultCountryTest() {

    $country = country();
    $countries = $country->search(select: "*", limit: 1000, object: true);
    $count = count($countries) -1;
    $c = rand(0, $count);


    isTrue(country($countries[$c]->alpha2)->idx == $countries[$c]->idx, "read via 2digitcode");
    isTrue(country($countries[$c]->alpha3)->idx == $countries[$c]->idx, "read via 3digitcode");

    $c = rand(0, $count);
    $c3 = country($countries[$c]->alpha3, true);
    isTrue($c3->hasError, "should be error, currency code is set to true");
    isTrue($c3->getError() == e()->entity_not_found, "should not exist since 3digit code is different from currencycode");

    $c = rand(0, $count);
    isTrue(country($countries[$c]->idx)->idx == $countries[$c]->idx, "read via idx");

}

function countryModelTest() {

    isTrue(country()->count() == 245, "No of countries must be 245");
    isTrue(country('kr')->alpha3 == 'KOR', "alpha3 of Korea must be KOR");
    isTrue(country('kr')->numericCode == 410, "numericCode of Korea must be 410");
    isTrue(country('kr')->currencyCode == 'KRW', "currencyCode of Korea must be KRW");
    isTrue(country('kr')->koreanName == '대한민국', "koreanName of Korea must be 대한민국");

    isTrue(country('usa')->currencyCode == 'USD', "currencyCode of USA must be USD");

    isTrue(country('hk')->currencySymbol == 'HK$', "currencySymbol of HK must be HK$");

    isTrue(country(1)->idx == 1, 'country idx 1 must have idx 1');

}