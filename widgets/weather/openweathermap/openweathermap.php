

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

        $graph = [];
        $max = 0;
        /**
         * start of the dot
         */
        $base_left = 25;
        /**
         * distance between dot
         */
        $w = 66;
        /**
         * height of the graph
         */
        $h = 50;
        foreach($re->list as $i => $list) {
            if ($max < $list->main->temp) $max = $list->main->temp;
        }


        ?>
        <h4><?=$city?>, <?=$twoDigitCode?></h4>
        <div class=" overflow-auto ">


            <figure class="css-chart" style="height: <?=$h?>px;">
                <ul class="line-chart fs-sm">
                    <?php
                    $count = count($re->list);
                    foreach($re->list as $i => $list) {
                        $temp = $list->main->temp;
                        $bottom = ( $temp / $max) * $h;
                        $left = $base_left + ($i * $w);
                        $hypotenuse = 0;
                        $deg = 0;
                        if( $i !=  $count -1 ) {
                            $next_temp = $re->list[$i + 1];
                            $opposite = $temp - $next_temp->main->temp;
                            $hypotenuse = sqrt(pow($w,2) + pow($opposite, 2));
                            $deg = asin($opposite /  $hypotenuse) * (180 / pi());
                        }
                    ?>
                    <li>
                        <div class="data-point" style="bottom: <?=$bottom?>px; left: <?=$left?>px;">
                            <span class="ml-1"><?=round($list->main->temp)?></span>
                        </div>
                        <div class="line-segment"
                             style="bottom: <?=$bottom+3?>px; left: <?=$left+3?>px; width: <?=$hypotenuse?>;transform: rotate(calc(<?=$deg?> * 1deg));"
                        ></div>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </figure>


<!--            <figure class="css-chart" style="height: 150px;">-->
<!--                <ul class="line-chart">-->
<!--                    <li>-->
<!--                        <div class="data-point fs-sm" data-value="25" style="bottom: calc(3.3333px - 8px);left: calc(0px - 8px);">33</div>-->
<!--                        <div class="line-segment"-->
<!--                             style="bottom: 3.3333px;left: 0;transform: rotate(calc(-71.07 * 1deg));width: calc(123.33 * 1px);"></div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <div class="data-point" data-value="60" style="bottom: calc(120px - 8px);left: calc(40px - 8px);"></div>-->
<!--                        <div class="line-segment"-->
<!--                             style="bottom: 120px;left: 40px; transform: rotate(calc(51.34 * 1deg));width: calc(64.03 * 1px);"></div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <div class="data-point" data-value="25" style="bottom: calc(70px - 8px);left: calc(80px - 8px);"></div>-->
<!--                        <div class="line-segment"-->
<!--                             style="bottom: 70px;left: 80px;transform: rotate(calc(-22.61 * 1deg));width: calc(43.33 * 1px);"></div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <div class="data-point" data-value="50" style="bottom: calc(87px - 8px);left: calc(120px - 8px);"></div>-->
<!--                        <div class="line-segment"-->
<!--                             style="bottom: 87px;left: 120px;transform: rotate(calc(39.805 * 1deg));width: calc(52.06 * 1px);"></div>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <div class="data-point" data-value="40" style="bottom: calc(53.333px - 8px);left: calc(160px - 8px);"></div>-->
<!--                        <div class="line-segment"-->
<!--                             style="bottom: 53.333px;left: 160px;transform: rotate(calc(0 * 1deg));width: calc(0 * 1px);"></div>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </figure>-->
            <div class="d-flex mb-3 text-center fs-xs">
                <?php
                foreach($re->list as $list) { ?>
                    <div class="px-2">
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
        </div>
    <?php } ?>

</div>
