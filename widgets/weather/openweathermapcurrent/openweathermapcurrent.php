<?php
/**
 * @size narrow
 * @options string `cacheCode`(optional), integer `cacheTime`(optional)
 * @dependency https://openweathermap.org/
 * @description display current weather
 */
?>
<div>
    <?php
    $o = getWidgetOptions();
    $cacheCode = $o['cacheCode'] ?? "current";
    $cacheTime = $o['cacheTime'] ?? 60 * 25;

    $country = get_current_country(clientIp());
    $city = $country->city;
    $twoDigitCode = $country->v('2digitCode');

    // @TODO language support for open weather map does not follow the standard.
    // https://openweathermap.org/forecast5#multi
    // Need a conversion.
    $lang = get_user_language();
    if ( $lang == 'ko' ) $lang = 'kr';

    $weatherCode =  $cacheCode . $lang . $city;
    $weather = cache($weatherCode);
    if ( $weather->expired( $cacheTime  ) ) {
        $weather->renew();
        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city,$twoDigitCode&lang=$lang&units=metric&appid=" . OPENWEATHERMAP_API_KEY;
        $res = file_get_contents($url);
        $weather->set($res);
        $re = json_decode($res);
    } else {
        $re = json_decode($weather->data);
    }
    $current = $re;
    ?>
    <div>
        <h5 class="mb-0">
            <?=$city?>, <?=$twoDigitCode?> <?=round($current->main->temp)?>℃
            <img src="https://openweathermap.org/img/wn/<?=$current->weather[0]->icon?>.png">
        </h5>
        <div>
            Feels like <?=$current->main->feels_like?> ℃.
        </div>
        <div class="text-capitalize"><?=$current->weather[0]->description?></div>
        <div>
            Humidity: <?=$current->main->humidity?>%
        </div>
        <div>
            Min <?=round($current->main->temp_min)?> ℃. - Max <?=round($current->main->temp_max)?> ℃.
        </div>
    </div>
</div>
