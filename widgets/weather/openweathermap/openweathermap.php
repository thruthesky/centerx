<div>
    <?php
    $options = getWidgetOptions();

    /**
     * @display current|forecast
     */
    $display = $options['display'] ?? 'current';

    $country = get_current_country('124.83.114.70'); /// @update this.
    $city = $country->city;
    $twoDigitCode = $country->v('2digitCode');

    $weatherCode =  "weather12" . $city;
    $cache = cache($weatherCode);
    if($cache->exists() && $cache->olderThan(60*60*4)) {
        $re = json_decode($cache->data);
    } else {
//        if($weather == 'current') $res = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$city,$twoDigitCode&units=metric&appid=" . OPENWEATHERMAP_API_KEY);
//        if($weather == 'forecast') $res = file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=$city,$twoDigitCode&units=metric&appid=" . OPENWEATHERMAP_API_KEY);

        $res = file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=$city,$twoDigitCode&units=metric&appid=" . OPENWEATHERMAP_API_KEY);
//        d($res);
        cache($weatherCode)->set($res);
        $re = json_decode($res);
    }

    if($display == 'current'){
        $current = $re->list[0];
        ?>
        <div>
            <h5 class="mb-0">
                <?=$city?>, <?=$twoDigitCode?> <?=round($current->main->temp)?>℃
                <img src="http://openweathermap.org/img/wn/<?=$current->weather[0]->icon?>.png">
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
        <?php
    }
    if($display == 'forecast') {
        ?>
        <div><?=$city?>, <?=$twoDigitCode?></div>
        <div class="d-flex text-center overflow-auto fs-xs">
            <?php
            foreach($re->list as $list) { ?>
                <div class="pr-3">
                    <div><?=date('g A', $list->dt)?></div>
                    <div><?=date('D', $list->dt)?></div>
                    <div><img src="http://openweathermap.org/img/wn/<?=$list->weather[0]->icon?>.png"></div>
                    <div><?=round($list->main->temp_min)?>℃  <?=round($list->main->temp_max)?>℃</div>
                </div>
                <?php
//            d($list); exit;
            }
            ?>
        </div>
    <?php } ?>

</div>
