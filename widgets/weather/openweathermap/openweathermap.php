<div>
    <h3>Open Weather Map</h3>
    <pre>
    - Get user location.
    - Get weather of user location (from Cache or save into Cache)
    - Display weather.
    </pre>


    <?php
    $fetch = true;
    if($fetch) {
        $re = json_decode('{"coord":{"lon":120.9822,"lat":14.6042},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"base":"stations","main":{"temp":305.43,"feels_like":310.26,"temp_min":304.76,"temp_max":306.09,"pressure":1007,"humidity":58},"visibility":10000,"wind":{"speed":2.68,"deg":82,"gust":4.47},"clouds":{"all":40},"dt":1620377919,"sys":{"type":2,"id":2008256,"country":"PH","sunrise":1620336660,"sunset":1620382454},"timezone":28800,"id":1701668,"name":"Manila","cod":200}');
    } else {
        $country = get_current_country('124.83.114.70');

        d(" {$country->city}, " . $country->v('2digitCode'));

        $city = $country->city;
        $country = $country->v('2digitCode');

        $re = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$city,$country&appid=7cb555e44cdaac586538369ac275a33b");
    }

    d("get_current_country");
    $country = get_current_country('120.29.76.142');
    d($country, "country~~~~");
    d(" {$country->city}, " . $country->v('2digitCode'));

    d($re, "USER Current Weather");

    ?>
    <?=$re->weather[0]->description?>
    <img src="http://openweathermap.org/img/wn/<?=$re->weather[0]->icon?>.png">

</div>
