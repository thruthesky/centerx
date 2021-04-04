<?php
/**
 * @file currency-default.php
 */
/**
 *
 * @example
 * ```php
 * $currencies = country_currency(cafe()->currencyCode());
 * include widget('currency/currency-default', ['currencies' => $currencies]);
 * ```
 */
$o = getWidgetOptions();
$currencies = $o['currencies'];
?>
<div class="box border-radius-md mb-2 p-3 fs-sm">
    오늘의 환율
    <hr>
    <?php
//    $letters = country_currency_korean_letter();
//    foreach( $currencies as $names => $rate ) {
//        list ($src, $dst ) = convert_currency_codes_to_names($names);
//
//        if ( $rate < 10 ) $rate = round($rate, 3);
//        else $rate = round($rate, 2);
//
//        echo "<div>";
//        echo "1 $src : $rate $dst";
//        echo "</div>";
//    }
    ?>
    <hr>
    환율 기준시간: <?=date('m월 d일 H시')?>
</div>
