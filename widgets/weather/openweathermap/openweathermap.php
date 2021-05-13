



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
        $res = file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=$city,$twoDigitCode&units=metric&appid=" . OPENWEATHERMAP_API_KEY);

        cache($weatherCode)->set($res);
        $re = json_decode($res);
    }

    if($display == 'current'){
        $current = $re->list[0];
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

        $current = [
                "current" => []
        ];
        $forecast  = [];
        foreach($re->list as $i => $list) {
            if ($max < $list->main->temp) $max = $list->main->temp;
            if ($i < 8) {
                $current['current'][] = $list;
            }
            $md = date("md", $list->dt);
            if(!isset($forecast[$md]))  $forecast[$md] = [];
            $forecast[$md][] = $list;
        }
        $forecast = array_slice($forecast,1);

        $forecast = array_merge($current,$forecast);


        ?>


        <?php js('/etc/js/chartjs-2/chart.bundle.min.js', 0) ?>
        <canvas id="myChart" width="400" height="400"></canvas>
        <script>
            later(function(){
                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                        datasets: [{
                            label: '# of Votes',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            })
        </script>




        <h4><?=$city?>, <?=$twoDigitCode?></h4>
        <div>
            <b-card no-body>
                <b-tabs card>
                    <?php foreach($forecast as $d => $day) { ?>
                    <b-tab class="p-0" title="<?=$d?>">
                        <figure class="css-chart" style="height: <?=$h?>px;">
                            <ul class="line-chart fs-sm">
                                <?php
                                foreach($day as $i => $list) {
                                    $temp = $list->main->temp;
                                    $bottom = ( $temp / $max) * $h;
                                    $left = $base_left + ($i * $w);
                                    $hypotenuse = 0;
                                    $deg = 0;
                                    if( $i < count($day) -1 ) {
                                        $next_temp = $day[$i + 1];
                                        $opposite = $temp - $next_temp->main->temp;
                                        $hypotenuse = sqrt(pow($w,2) + pow($opposite, 2));
                                        $deg = asin($opposite /  $hypotenuse) * (180 / pi());
                                    }
                                    ?>
                                    <li>
                                        <div class="data-point" style="bottom: <?=$bottom?>px; left: <?=$left?>px;">
                                            <span class="d-inline-block ml-1"><?=round($list->main->temp)?></span>
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
                        <div class="d-flex justify-content-start mb-3 text-center fs-xs">
                            <?php
                            foreach($day as $list) { ?>
                                <div class="px-2">
                                    <div><?=date('g A', $list->dt)?></div>
                                    <div><?=date('D', $list->dt)?></div>
                                    <div><img src="http://openweathermap.org/img/wn/<?=$list->weather[0]->icon?>.png"></div>
                                    <div><?=round($list->main->temp_min)?>℃  <?=round($list->main->temp_max)?>℃</div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </b-tab>
                    <?php } ?>
                </b-tabs>
            </b-card>
        </div>

    <?php } ?>

</div>
