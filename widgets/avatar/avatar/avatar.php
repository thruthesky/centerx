<?php
/**
 * @size icon
 * @option string 'photoUrl'
 */
$o = getWidgetOptions();
if ( isset($o['photoUrl']) ) {
    $photoUrl = $o['photoUrl'];
} else {
    $photoUrl = '/widgets/avatar/avatar/avatar.jpg';
}
$size = $o['size'] ?? '50';
?>
<img class="mr-3 shadow-sm" style="height: <?= $size ?>px !important; width: <?= $size ?>px !important; border-radius: 50%;" src="<?= $photoUrl ?>" />

