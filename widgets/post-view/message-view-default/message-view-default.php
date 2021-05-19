<?php

/**
 * @name 쪽지 - 읽기
 */


$post = post()->current();
$comments = $post->comments();
?>

    <section class="post-view-default p-3 mb-5" style="border-radius: 16px; background-color: #f4f4f4;">
        <div class="pb-1" style="word-break: normal">
            <h3><?= $post->title ?></h3>
        </div>

        <div class="post-meta-default d-flex">
            <?php include widget('user/user-avatar', ['user' => $post->user(), 'size' => '70']) ?>
            <div class="meta">
                <div><?=ln('sender')?> : <b><?=$post->user()->nicknameOrName?></b></div>
                <div class="text-muted">
                    <?= date('r', $post->createdAt) ?>
                </div>
            </div>
        </div>


        <section class="post-body">
            <div class="content box mt-3" style="white-space: pre-wrap;"><?= $post->content ?></div>
            <!-- FILES -->
            <?php include widget('files-display/files-display-default', ['files' => $post->files()]) ?>
            <hr class="my-1">
            <div class="d-flex buttons mt-2">
                <div class="d-flex">
                    <a class="btn btn-sm mr-2" href="<?=messageSendUrl($post->userIdx)?>"><?=ln('send_message')?></a>
                </div>
                <span class="flex-grow-1"></span>
                <a class="btn btn-sm mr-1" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ek('List', '목록') ?></a>
                <?php if ($post->isMine()) { ?>
                    <div>
                        <a class="btn btn-sm" href="/?p=forum.post.delete.submit&idx=<?= $post->idx ?>" style="color: red" onclick="return confirm('<?= ek('Delete Post?', '@T Delete Post') ?>')">
                            <?= ek('Delete', '삭제') ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </section>
    </section>

