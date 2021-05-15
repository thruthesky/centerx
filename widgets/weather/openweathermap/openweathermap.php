<div>
    <?php
    $options = getWidgetOptions();

    /**
     * @display current|forecast
     */
    $display = $options['display'] ?? 'current';

    if ( isLocalhost() ) $ip = '124.83.114.70';
    else $ip = null;
    $country = get_current_country($ip); /// @update this.
    $city = $country->city;
    $twoDigitCode = $country->v('2digitCode');

//    d($country);

//    d(get_user_language());


    // @TODO language support for open weather map does not follow the standard.
    // https://openweathermap.org/forecast5#multi
    // Need a conversion.
    $lang = get_user_language();
    if ( $lang == 'ko' ) $lang = 'kr';

    $weatherCode =  "weather18" . $lang . $city;
    $weather = cache($weatherCode);
    if ( $weather->expired( 60 * 60 * 1 ) ) {
        $weather->renew();
        // 60 seconds.
        $url = "https://api.openweathermap.org/data/2.5/forecast?q=$city,$twoDigitCode&lang=$lang&units=metric&appid=" . OPENWEATHERMAP_API_KEY;
        $res = file_get_contents($url);
        $weather->set($res);
        $re = json_decode($res);

    } else {
        $re = json_decode($weather->data);
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

        $current = [ "current" => [] ];
        $currentjs = [ "current" => [] ];
        $forecast  = [];
        $forecastjs  = [];
        foreach($re->list as $i => $list) {
            if ($i < 8) {
                $current['current'][] = $list;
                $currentjs['current'][] = round($list->main->temp);
            }
            $md = date("md", $list->dt);
            if(!isset($forecast[$md])) {
                $forecast[$md] = [];
                $forecastjs[$md] = [];
            }
            $forecast[$md][] = $list;
            $forecastjs[$md][] = round($list->main->temp);
        }
        $forecast = array_slice($forecast,1);
        $forecast = array_merge($current,$forecast);
        $forecastjs = array_slice($forecastjs,1);
        $forecastjs = array_merge($currentjs,$forecastjs);


        ?>

        <h4><?=$city?>, <?=$twoDigitCode?></h4>
        <div>
            <b-card no-body>
                <b-tabs card>
                    <?php foreach($forecast as $d => $day) { ?>
                        <b-tab class="p-0" title="<?=$d?>">
                            <canvas id="<?=$d?>" ></canvas>
                            <div class="d-flex justify-content-between mb-3 text-center fs-xs">
                                <?php
                                foreach($day as $list) { ?>
                                    <div class="px-2">
                                        <div><?=date('g A', $list->dt)?></div>
                                        <div><?=date('D', $list->dt)?></div>
                                        <div><img src="https://openweathermap.org/img/wn/<?=$list->weather[0]->icon?>.png"></div>
                                        <div>
                                            <?php if ( round($list->main->temp_min) == round($list->main->temp_max) ) { ?>
                                                <?=round($list->main->temp_min)?>℃
                                            <?php } else { ?>
                                            <?=round($list->main->temp_min)?>℃  <?=round($list->main->temp_max)?>℃
                                            <?php } ?>
                                        </div>
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

    <?php js('/etc/js/chartjs-2/chart.bundle.min.js', 0) ?>
    <?php js('/etc/js/chartjs-2/chartjs-plugin-datalabels.min.js', 0) ?>

        <script>
            later(function(){

                let dataset = <?=json_encode($forecastjs)?>;
                // console.log(dataset);

                Object.keys(dataset).forEach(function(key) {
                    loadChart(key, dataset[key]);
                });

                function loadChart(id, data) {
                    // console.log(id, data);
                    var ctx = document.getElementById(id);
                    ctx.height = "50";
                    var myCharts = {};
                    myCharts[id] = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data,
                            datasets: [{
                                label: 'temp',
                                data: data,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    // 'rgba(54, 162, 235, 0.2)',
                                    // 'rgba(255, 206, 86, 0.2)',
                                    // 'rgba(75, 192, 192, 0.2)',
                                    // 'rgba(153, 102, 255, 0.2)',
                                    // 'rgba(255, 159, 64, 0.2)',
                                    // 'rgba(153, 102, 255, 0.2)',
                                    // 'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    // 'rgba(54, 162, 235, 1)',
                                    // 'rgba(255, 206, 86, 1)',
                                    // 'rgba(75, 192, 192, 1)',
                                    // 'rgba(153, 102, 255, 1)',
                                    // 'rgba(255, 159, 64, 1)',
                                    // 'rgba(153, 102, 255, 1)',
                                    // 'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                datalabels: {
                                    align: 'end',
                                    // anchor: 'end',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 4
                                }
                            },
                            tooltips: {
                                enabled: false
                            },
                            layout: {
                                padding: {
                                    left: 16,
                                    right: 16,
                                    top: 25,
                                    bottom: 10
                                }
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: {
                                        display: false
                                    },
                                }],
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        display: false,
                                    },
                                    gridLines: {
                                        display: false
                                    },
                                }]

                            },
                        },
                    });
                }


            })
        </script>

    <?php } ?>

</div>
