<?php

/**
 * @name 쪽지 - 읽기
 */



$post = message()->current();


if ( $post->userIdx != login()->idx && $post->otherUserIdx != login()->idx ) {
    return include widget('info/error-wrong-route');
}

$post->readAt();


if ( $post->userIdx == login()->idx ) $inbox = false;
else $inbox = true;

$sender = user( $post->userIdx );
$receiver = user($post->otherUserIdx);

?>

    <section class="post-view-default p-3 mb-5">
        <div class="pb-1">
            <h3><?= $post->privateTitle ?></h3>
        </div>

        <div class="post-meta-default d-flex">
            <?php include widget('user/user-avatar', ['user' => $inbox ? $sender : $receiver, 'size' => '70']) ?>
            <div class="meta">
                <div>
                        <?php if ( $inbox ) { ?>
                            <?=ln('sender')?>: <?=$sender->nicknameOrName?>
                        <?php } else { ?>
                            <?=ln('receiver')?>: <?=$receiver->nicknameOrName?>
                        <?php } ?>
                </div>
                <div class="text-muted">
                    <?= date('r', $post->createdAt) ?>
                </div>
            </div>
        </div>


        <section class="post-body">
            <div class="content box mt-3"><?= $post->privateContent ?></div>
            <!-- FILES -->
            <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
            <hr class="my-1">
            <div class="d-flex buttons mt-2">
                <div class="d-flex">
                    <a class="btn btn-sm mr-2" href="<?=messageSendUrl( $inbox ? $post->userIdx : $post->otherUserIdx )?>"><?=ln('send_message')?></a>
                </div>
                <span class="flex-grow-1"></span>
                <a class="btn btn-sm mr-1" href="<?= $inbox ? messageInboxUrl() : messageOutboxUrl() ?>"><?=ln('list')?></a>
                <?php if ($post->sentToMe()) { ?>
                    <div>
                        <a class="btn btn-sm red" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>" onclick="return confirm('<?=ln('confirm_delete')?>')">
                            <?=ln('delete') ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </section>
    </section>

