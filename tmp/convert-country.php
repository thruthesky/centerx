<?php
require_once '/root/boot.php';

$geo = json_decode(file_get_contents('/root/etc/data/country-centroid-geo-location.json'), true);
$code = json_decode(file_get_contents('/root/etc/data/country-code.json'), true);
$currency = json_decode(file_get_contents('/root/etc/data/country-currency-code.json'), true);
$ko = json_decode(file_get_contents('/root/etc/data/country-currency-korean-letter.json'), true);

$geoData = [];
foreach( $geo as $data ) {
    $geoData[$data['country']] = $data;
}



foreach($code as $twoChar => $data ) {
    if ( isset($geoData[ $twoChar ]) && $geoData[ $twoChar ] ) {
        $data['CountryNameEN'] = $geoData[ $twoChar ]['name'];
        $data['latitude'] = $geoData[ $twoChar ]['latitude'];
        $data['longitude'] = $geoData[ $twoChar ]['longitude'];
    } else {
        $data['latitude'] = '';
        $data['longitude'] = '';
    }
    if ( isset($currency[$twoChar]) ) {
        $data['currencyCode'] = $currency[$twoChar]['currencyId'];
        if ( isset( $ko[$data['currencyCode']]) ) {
            $data['currencyKoreanName'] = $ko[$data['currencyCode']]['Code'] ?? '';
            $data['currencySymbol'] = $ko[$data['currencyCode']]['Symbol'] ?? '';
        } else {
            $data['currencyKoreanName'] = '';
            $data['currencySymbol'] = '';
        }
    } else {
        $data['currencyCode'] = '';
        $data['currencyKoreanName'] = '';
        $data['currencySymbol'] = '';
    }
    country()->create($data);
}
