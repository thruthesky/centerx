<?php

$o = getWidgetOptions();


if ( !isset($o['reminders']) || empty($o['reminders']) ) return;

foreach( $o['reminders'] as $post ) {
    ?>
    <div class="alert alert-info">
        <a href="<?=$post->url?>"><?=$post->title?></a>
    </div>
<?php
}