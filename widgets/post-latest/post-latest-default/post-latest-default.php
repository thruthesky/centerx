<?php
$o = getWidgetOptions();
$posts = post()->latest(limit: $o['limit'] ?? 10);
?>
<section id="<?=$o['id']??''?>" class="post-latest-default">
<?php
foreach($posts as $post) {
    ?>
    <a style="word-break: break-all" href="<?=$post->url?>"><?=$post->title?></a>
<?php
}
?>
</section>
