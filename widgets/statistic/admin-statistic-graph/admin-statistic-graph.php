<?php


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
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label>4/1</label>
            </div>
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label>4/2</label>
            </div>
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label>4/3</label>
            </div>
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label>4/4</label>
            </div>
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label>4/1</label>
            </div>
            <div class="mr-1">
                <div class="d-flex align-items-end">
                    <div class="bar-item post" style="height: 105px"></div>
                    <div class="bar-item comment" style="height: 250px"></div>
                    <div class="bar-item user" style="height: 160px"></div>
                </div>
                <label>4/5</label>
            </div>
        </div>


    </div>
</section>