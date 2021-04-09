<?php

//$now = time();
//$past = mktime(0,0,0, date('m',$now), date('d',$now) - 7);

$now = time();
$summary = [];




for($x=0; $x<31; $x++) {
    $start_stamp = mktime(0,0,0, null, date('j',$now) - $x);
    $end_stamp = $start_stamp + 60*60*24 - 1;

    $summary[] = [
            'date' => date('n/j', $start_stamp),
            'users'=> user()->count(where: "createdAt>=$start_stamp AND createdAt<=$end_stamp"),
            'posts'=> post()->count(where: "createdAt>=$start_stamp AND createdAt<=$end_stamp AND parentIdx=0"),
            'comments'=> post()->count(where: "createdAt>=$start_stamp AND createdAt<=$end_stamp AND parentIdx!=0"),
    ];
}

//d($summary);


?>

<style>
    .bar-graph-content {
        overflow: auto;
        display: flex;
        justify-content: flex-start;
        align-items: flex-end;
        padding: 1.1em 1.5em 0 1em;
        font-size: .8em;
    }
    .bar-graph-content .bar-item {
        position: relative;
        margin: 0 2px 0 0;
        width: 4px;
        min-height: 1px;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        border-bottom: 0.5px solid gray;
        background-color: gray;
        text-align: center;
    }
    .bar-graph-content label {
        display: block;
        font-size: 8px;
        text-align: center;
    }
    .bar-item.post {
        border-bottom: 1px solid green;
        background-color: green;
    }
    .bar-item.comment {
        border-bottom: 1px solid blue;
        background-color: blue;
    }
    .bar-item.user {
        border-bottom: 1px solid red;
        background-color: red;
    }

</style>

<section class="p-3">
    <div>Recent Users, Posts, Comments (Green: post, Blue: comment, Red: user)</div>


    <div class="bar-graph-container">
        <div class="bar-graph-content">
            <?php
            foreach ($summary as $day) {
            ?>
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label><?=$day['date']?></label>
            </div>
            <?php } ?>
        </div>


    </div>
</section>