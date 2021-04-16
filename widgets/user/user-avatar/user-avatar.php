<?php
$o = getWidgetOptions();

$url = $o['photoUrl'];
$size = $o['size'] ?? '70';

if ($url) { ?>
    <img class="mr-3" style="height: <?= $size ?>px; min-width: <?= $size ?>px; border-radius: 50px;" src="<?= $url ?>" />
<?php } else { ?>
    <div class="mr-3" style="height: <?= $size ?>px; min-width: <?= $size ?>px; border-radius: 50px; background-color: grey"> </div>
<?php } ?>