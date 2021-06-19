<?php
/**
 * @size icon
 * @description Message sound on off. This plays sounds and set on/off on sound alerty with Vue.js
 */
$op = getWidgetOptions();
$sound = message()->countNewMessage() > 0;

if ( $sound ) {
    $sound = login()->playNewMessageSound != 'N';
}
?>
<new-message-sound-on-off option="<?=login()->playNewMessageSound?>"></new-message-sound-on-off>
<?php js('/etc/js/vue-js-components/new-message-sound-on-off.js')?>



<?php
    // 여러 번 포함되어도 소리는 한번만 출력.
    if ( $sound && !defined('MESSAGE_SOUND_PLAYED') ) {
        define("MESSAGE_SOUND_PLAYED", true);
    ?>
    <audio autoplay="autoplay">
        <source src="/etc/sound/alert.ogg" />
        <source src="/etc/sound/alert.mp3" />
    </audio>
<?php } ?>


