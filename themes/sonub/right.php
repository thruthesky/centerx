<?php

?>

<div class="box mb-2 border-radius-md">
    <?php include widget('login/login')?>

    <?php
    if ( cafe()->isMine() ) {
        ?>
        <hr>
        <a href="/?cafe.admin"><?=ln('cafe_admin')?></a>
        <?php
    }
    ?>
</div>

<section class="box mb-2">
    <a href="/?cafe.create">카페 개설하기</a>
</section>

<?php include widget('message/message-side-menu')?>

<section class="box mb-2">
    <h1>Weather</h1>
    <hr>
    <?php include widget('weather/openweathermapcurrent') ?>
</section>


<section class="box">
    <h1>Latest Post</h1>
    <hr>
    <?php include widget('post/2x2-photo-top-text-bottom'); ?>
</section>