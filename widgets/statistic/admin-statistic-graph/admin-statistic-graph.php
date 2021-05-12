<?php
$now = time();
$summary = [];
$highest = [
    'users' => 0,
    'posts' => 0,
    'comments' => 0
];

for ($x = 0; $x < 31; $x++) {
    $start_stamp = mktime(0, 0, 0, null, date('j', $now) - $x);
    $end_stamp = $start_stamp + 60 * 60 * 24 - 1;

    $usersCount = user()->count(where: "createdAt>=? AND createdAt<=?", params: [$start_stamp, $end_stamp]);
    $postsCount = post()->count(where: "createdAt>=? AND createdAt<=? AND parentIdx=?", params: [$start_stamp, $end_stamp, 0]);
    $commentsCount = post()->count(where: "createdAt>=? AND createdAt<=? AND parentIdx!=?", params: [$start_stamp, $end_stamp, 0]);

    if ($usersCount > $highest['users']) $highest['users'] = $usersCount;
    if ($postsCount > $highest['posts']) $highest['posts'] = $postsCount;
    if ($commentsCount > $highest['comments']) $highest['comments'] = $commentsCount;

    $summary[] = [
        'date' => date('n/j', $start_stamp),
        'users' => $usersCount,
        'posts' => $postsCount,
        'comments' => $commentsCount,
    ];
}

//d($summary);

function barHeight($no, $max = null): int
{
    if (!$no || $no === 0) {
        return '1';
    }
    if ($no < 0) {
        $no = abs($no);
    }
    if ($max) {
        return floor($no / $max * 100);
    }
    return floor($no);
}


?>

<style>
    .bar-graph-content {
        overflow: auto;
        display: flex;
        justify-content: flex-start;
        align-items: flex-end;
        padding: 1.1em 1.5em 0 0;
        font-size: .8em;
    }

    .bar-graph-content .bar-item {
        position: relative;
        margin: 0 2px 0 0;
        width: 4px;
        min-height: 1px;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        border-bottom: 1px solid gray;
        background-color: gray;
        text-align: center;
    }

    .bar-graph-content label {
        display: block;
        font-size: 8px;
        text-align: center;
    }

    .bar-item.posts {
        border-bottom: 1px solid #09A021;
        background-color: #09A021;
    }

    .bar-item.comments {
        border-bottom: 1px solid #1E85FF;
        background-color: #1E85FF;
    }

    .bar-item.users {
        border-bottom: 1px solid #ff0000;
        background-color: #ff0000;
    }
</style>

<section data-cy="admin-statistic-graph-widget" class="d-flex flex-column justify-content-between p-3" style="height: 24rem">
    <h6 class="mt-2 fw-700">Recent Users, Posts, Comments</h6>
    <div class="fs-sm d-flex">
        <div class="mr-2 d-flex align-items-center">
            <div class="mr-2" style="width: 20px; height: 10px; background-color: green;"></div>
            <span>Posts</span>
        </div>
        <div class="mr-2 d-flex align-items-center">
            <div class="mr-2" style="width: 20px; height: 10px; background-color: Blue;"></div>
            <span>Comments</span>
        </div>
        <div class="mr-2 d-flex align-items-center">
            <div class="mr-2" style="width: 20px; height: 10px; background-color: red;"></div>
            <span>Users</span>
        </div>
    </div>
    <div class="bar-graph-container">
        <div class="bar-graph-content">
            <?php
            foreach ($summary as $day) {
            ?>
                <div class="mr-1">
                    <div class="d-flex align-items-end">
                        <div class="bar-item posts" title="Posts: <?= $day['posts'] ?>" style="height: <?= barHeight($day['posts'], $highest['posts']) * 2.5 ?>px"></div>
                        <div class="bar-item comments" title="Comments: <?= $day['comments'] ?>" style="height: <?= barHeight($day['comments'], $highest['comments']) * 2.5 ?>px"></div>
                        <div class="bar-item users" title="Users: <?= $day['users'] ?>" style="height: <?= barHeight($day['users'], $highest['users']) * 2.5 ?>px"></div>
                    </div>
                    <label><?= $day['date'] ?></label>
                </div>
            <?php } ?>
        </div>
    </div>
</section>