<?php

?>
<section class="box mb-2">
    <h1>카페 개설하기</h1>
    <hr>
    <?php include widget('cafe/cafe-create') ?>
</section>

<section class="box">
    <h1>Weather</h1>
    <hr>
    <?php include widget('weather/openweathermapcurrent') ?>
</section>


<section class="box">
    <h1>Latest Post</h1>
    <hr>
    <?php include widget('post/four-stories-with-thumbnail'); ?>
</section>