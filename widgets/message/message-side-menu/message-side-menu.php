<?php

    $newMessage = message()->countNewMessage();

?>
<div class="d-flex justify-content-between">
    <a class="d-flex align-items-center" href="<?=messageInboxUrl()?>">
        받은 쪽지
        <div class="new-message d-flex align-items-center justify-content-center ml-1 bg-red white size-chip radius-50">
            <div><?=$newMessage?></div>
        </div>
    </a>
    <a href="<?=messageOutboxUrl()?>">보낸 쪽지 </a>
</div>
