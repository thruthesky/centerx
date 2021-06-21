<?php
/**
 * @name 쪽지 - 목록
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];


if ( in('userIdx') != login()->idx && in('otherUserIdx') != login()->idx ) {
//    return include widget('info/error-wrong-route');
    jsGo(messageInboxUrl());
}

if ( in('otherUserIdx') ) $inbox = true;
else $inbox = false;

?>
<section class="post-list-default px-2 px-lg-0 bg-light">

        <div class="d-flex align-items-center justify-content-between">
            <h1>
                <?=$inbox ? "받은 쪽지 함" : "보낸 쪽지함"?>
            </h1>
            <div class="meta d-flex">
                <div>
                    전체 받은 쪽지: <?=message()->countInbox()?> / 새 쪽지: <?=message()->countNewMessage()?>
                </div>
                <div class="d-flex align-items-center ml-3">
                    <div class="mr-1">소리:</div>
                    <?php
                    include widget('message/sound-on-off');
                    ?>
                </div>
            </div>
        </div>
    <div>
        <?php
        if ( $posts ) {
            foreach ($posts as $post) {
                $receiver = user( $post->otherUserIdx );
                $sender = user( $post->userIdx );
                ?>
                <div class="d-flex">
                    <?php include widget('user/user-avatar', ['photoUrl' => $receiver->shortProfile()['photoUrl'], 'size' => '50']) ?>
                    <a href="<?= $post->url ?>">
                        <div class="<?=$post->readAt ? '' : 'em'?>"><?=$post->privateTitle?></div>
                        <div class="mt-1 text-muted">
                            <?php if ( $inbox ) { ?>
                                <?=ln('sender')?>: <?=$sender->nicknameOrName?>
                            <?php } else { ?>
                                <?=ln('receiver')?>: <?=$receiver->nicknameOrName?>
                            <?php } ?>
                            <?= $post->shortDate ?>
                        </div>
                    </a>
                </div>
                <hr>
            <?php }
        } else { ?>
            <div class="pb-3 d-flex justify-content-center"><?=ln('no_messages_yet')?></div>
        <?php } ?>
    </div>
</section>

