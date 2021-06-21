<?php

/**
 * @name Default Post List Style
 */
$o = getWidgetOptions();
$posts = $o['posts'];
$total = $o['total'];
if (empty($posts)) return include widget('post-list/empty-post-list');
?>
<?php include_once widget('post-list-reminder/post-list-reminder-default', ['reminders' => $o['reminders']]) ?>
<section class="post-list-default px-2 px-lg-0 mb-3">
    <div>
        <?php
        $rowNo = 0;
        foreach ($posts as $post) {
            $post = post(idx: $post->idx);
            $user = user(idx: $post->userIdx);

            if (in('categoryId') == null) {
                $_category = '(' . $post->categoryId() . ')';
            } else {
                $_category = '';
            }
        ?>
            <?= hook()->run(HOOK_POST_LIST_ROW, $rowNo, $posts) ?>
            <div class="d-flex">
                <?php include widget('user/user-avatar', ['photoUrl' => $user->shortProfile()['photoUrl'], 'size' => '50']) ?>
                <a href="<?=postViewUrl($post)?>" <?=hook()->run(HOOK_POST_LIST_TITLE_ATTR, $post)?>>
                    <div class="bold">No. <?= $post->idx ?> • 
                        <?php
                        if ($post->isPrivate) {
                            if ($post->userIdx == login()->idx || $post->otherUserIdx == login()->idx) {
                                echo $post->privateTitle;
                            }
                        } else {
                            echo $post->title;
                        }
                        ?>
                    </div>
                    <div class="mt-1 text-muted">
                        <?= $_category ?>
                        <?= $post->subcategory ? "<span class='badge badge-info'> {$post->subcategory} </span>" : "" ?>
                        <span class="badge badge-info"><?= $post->categoryId() ?></span> • 
                        <?= ln('no_of_views') ?>: <?= $post->noOfViews ?> • 
                        <?= $post->shortDate ?>
                    </div>
                </a>
            </div>
            <hr>
        <?php
            $rowNo++;
        }
        ?>
        <?= hook()->run(HOOK_POST_LIST_ROW, $rowNo, $posts) ?>
    </div>
</section>