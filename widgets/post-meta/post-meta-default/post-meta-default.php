<?php
$o = getWidgetOptions();

/**
 * @var CommentTaxonomy|PostTaxonomy $post
 */
$post = $o['post'];

$avatarPopoverId = "user-avatar-" . $post->idx;
$usernamePopoverId = "user-name-" . $post->idx;
?>

<div class="post-meta-default d-flex">
    <div id="<?= $avatarPopoverId ?>" class="pointer" @click="openPopover('<?= $avatarPopoverId ?>')" tabindex="0">
        <?php include widget('user/user-avatar', ['user' => $post->user(), 'size' => '70']) ?>
    </div>
    <div class="meta">
        <div>
            <b id="<?= $usernamePopoverId ?>" class="pointer block" @click="openPopover('<?= $usernamePopoverId ?>')" tabindex="0"><?= $post->user()->nicknameOrName ?></b>
        </div>
        <div class="text-muted">
            <?= $post->subcategory ? "<span class='badge badge-info'>{$post->subcategory}</span> " : "" ?>
            <?php if ($_ = hook()->run('post-meta-3rd-line', $post)) echo $_;
            else { ?>
                No. <?= $post->idx ?>
            <?php } ?>
        </div>
        <div class="text-muted">
            <?= ln('date') ?>: <?= $post->shortDate ?> •
            <?= ln('no_of_views') ?>: <?= $post->noOfViews ?>
        </div>
    </div>
</div>

<forum-popup-menu :id="'<?= $avatarPopoverId ?>'" :user-id="'<?= $post->userIdx ?>'"></forum-popup-menu>
<forum-popup-menu :id="'<?= $usernamePopoverId ?>'" :user-id="'<?= $post->userIdx ?>'"></forum-popup-menu>

<?php js(HOME_URL . 'etc/js/vue-js-components/user-popup-menu.js') ?>