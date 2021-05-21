<?php

/**
 * @name All In One: Create, List, View
 */

$o = getWidgetOptions();
$posts = $o['posts'];
?>


<?php include widget('post-edit/post-edit-default') ?>

<section class="post-list-all-in-one">

    <?php foreach ($posts as $post) {
        $_user = user($post->userIdx);
    ?>
        <div class="w-100 p-2 rounded" style="background-color: #f4f4f4;">
            <div class="post-view-header d-flex">
                <div>
                    <?php include widget('avatar/avatar', ['photoUrl' => $_user->photoUrl]) ?>
                </div>
                <a href="<?= $post->url ?>">
                    <div class="font-weight-bold">No. <?= $post->idx ?> <?= $post->title ?></div>
                    <div class="mt-2">
                        <?= category($post->categoryIdx)->id ?> -
                        <?= $post->shortDate ?>
                    </div>
                </a>
            </div>
            <div class="content p-2" style="background-color: #dcffff;">
                <?= $post->content ?>
            </div>
            <div class="files">
                <?php foreach ($post->files() as $file) { ?>
                    <div class="position-relative">
                        <img class="w-100" src="<?= $file->url ?>">
                        <div 
                            class="position-absolute" 
                            style="top: 0; color: white; background-color: black;" 
                            onclick="onClickFileDelete(<?= $file->idx ?>);"
                        >[ X ]</div>
                    </div>
                <?php } ?>
            </div>
            <div class="mt-3">
                <comment-form 
                    root-idx="<?= $post->idx ?>"
                    parent-idx="<?= $post->idx ?>" 
                    text-submit="<?= ln('submit') ?>" 
                    text-cancel="<?= ln('cancel') ?>">
                </comment-form>
            </div>
            <?php

            ?>
            <div class="comments mt-3">
                <?php foreach ($post->comments() as $comment) { ?>
                    <div class="mb-2 p-1 rounded" style="margin-left: <?= $comment->depth * 16 ?>px; background-color: #e0e0e0;">
                        <?php include widget('comment-view/comment-view-default', ['post' => $post, 'comment' => $comment]); ?>
                        <comment-form 
                            root-idx="<?= $post->idx ?>" 
                            parent-idx="<?= $comment->idx ?>" 
                            text-submit="<?= ln('submit') ?>" 
                            text-cancel="<?= ln('cancel') ?>" 
                            v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'"
                        ></comment-form>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</section>

<script>
    mixins.push({
        data: function() {
            return {
                displayCommentForm: {}
            };
        },
        methods: {
            onCommentEditButtonClick: function(idx, mode) {
                this.$set(this.displayCommentForm, idx, mode);
            },
        }
    });
</script>

<?php js('/etc/js/vue-js-components/comment-form.js', 1) ?>