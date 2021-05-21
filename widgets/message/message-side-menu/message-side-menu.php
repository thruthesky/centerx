<?php

    $newMessage = message()->countNewMessage();


?>
<section class="message-side-menu">
    <div class="d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <a class="d-flex align-items-center" href="<?=messageInboxUrl()?>">
                받은 쪽지
                <div class="new-message d-flex align-items-center justify-content-center ml-1 bg-red white size-chip radius-50">
                    <div><?=$newMessage?></div>
                </div>
            </a>

            <div class="ml-2"><?php include widget('message/sound-on-off') ?></div>
        </div>
        <a href="<?=messageOutboxUrl()?>">보낸 쪽지 </a>
    </div>
    <hr>
    <?php foreach( message()->latest(limit: 5) as $message ) { ?>
        <a class="d-block <?=$message->readAt ? '' : 'em'?>" href="<?=$message->url?>"><?=$message->privateTitle?></a>
    <?php } ?>
</section>
