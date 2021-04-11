<?php
$o = getWidgetOptions();
$posts = post()->latest(limit: $o['limit'] ?? 10);
?>
<section>
    <?php
    foreach($posts as $post) {
        ?>
        <a class="d-block p-2" href="<?=$post->url?>"><?=$post->title?></a>
        <?php
    }
    ?>
</section>
