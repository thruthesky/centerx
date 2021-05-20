<?php
/**
 * @size wide
 */
$o = getWidgetOptions();
?>
<section class="info-error p-5 bg-red white">
    <h2><?=$o['title'] ?? 'Error title'?></h2>
    <p class="mt-3">
        <?=$o['description'] ?? 'This is an error widget. There is no error description, yet.'?>
    </p>
</section>